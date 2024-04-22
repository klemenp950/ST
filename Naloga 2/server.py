"""An example of a simple HTTP server."""
import json
import mimetypes
import os
import pickle
import socket
from os import listdir
from os.path import isdir, isfile, join
from urllib.parse import unquote_plus

# Pickle file for storing data
PICKLE_DB = "db.pkl"

# Directory containing www data
WWW_DATA = "www-data"

# Header template for a successful HTTP request
RESPONSE_200 = """HTTP/1.1 200 OK\r
content-type: %s\r
content-length: %d\r
connection: Close\r
\r
"""

RESPONSE_301 = """HTTP/1.1 301 Moved Permanently\r
location: %s\r
content-type: %s\r
content-length: %d\r
connection: Close\r
\r
"""

# Represents a table row that holds user data
TABLE_ROW = """
<tr>
    <td>%d</td>
    <td>%s</td>
    <td>%s</td>
</tr>
"""

RESPONSE_400 = """HTTP/1.1 400 Bad Request\r
Content-Type: text/html; charset=iso-8859-1\r
Connection: Closed\r
\r
<!doctype html>
<h1>400 Bad Request</h1>
<p>Bad Request</p>
"""

RESPONSE_404 = """HTTP/1.1 404 Not found\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>404 Page not found</h1>
<p>Page cannot be found.</p>
"""

RESPONSE_405 = """HTTP/1.1 405 Method not allowed\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>405 Method not allowed</h1>
<p>Method not allowed.</p>
"""

DIRECTORY_LISTING = """<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Directory listing: %s</title>

<h1>Contents of %s:</h1>

<ul>
{{CONTENTS}}
</ul> 
"""

FILE_TEMPLATE = "  <li><a href='%s'>%s</li>"


def save_to_db(first, last):
    """Create a new user with given first and last name and store it into
    file-based database.

    For instance, save_to_db("Mick", "Jagger"), will create a new user
    "Mick Jagger" and also assign him a unique number.

    Do not modify this method."""

    existing = read_from_db()
    existing.append({
        "number": 1 if len(existing) == 0 else existing[-1]["number"] + 1,
        "first": first,
        "last": last
    })
    with open(PICKLE_DB, "wb") as handle:
        pickle.dump(existing, handle)


def read_from_db(criteria=None):
    """Read entries from the file-based DB subject to provided criteria

    Use this method to get users from the DB. The criteria parameters should
    either be omitted (returns all users) or be a dict that represents a query
    filter. For instance:
    - read_from_db({"number": 1}) will return a list of users with number 1
    - read_from_db({"first": "bob"}) will return a list of users whose first
    name is "bob".

    Do not modify this method."""
    if criteria is None:
        criteria = {}
    else:
        # remove empty criteria values
        for key in ("number", "first", "last"):
            if key in criteria and criteria[key] == "":
                del criteria[key]

        # cast number to int
        if "number" in criteria:
            criteria["number"] = int(criteria["number"])

    try:
        with open(PICKLE_DB, "rb") as handle:
            data = pickle.load(handle)

        filtered = []
        for entry in data:
            predicate = True

            for key, val in criteria.items():
                if val != entry[key]:
                    predicate = False

            if predicate:
                filtered.append(entry)

        return filtered
    except (IOError, EOFError):
        return []


def preisci_mapo(ime, pot):
    for el in os.listdir(pot):
        polno_ime = os.path.join(pot, el)
        if os.path.isdir(polno_ime):
            pot_datoteke = preisci_mapo(ime, polno_ime)
            if pot_datoteke:
                return pot_datoteke
        elif el == ime:
            return polno_ime
    return None


def process_request(connection, address):
    """Process an incoming socket request.

    :param connection is a socket of the client
    :param address is a 2-tuple (address(str), port(int)) of the client
    """

    # Read and parse the request line

    # Read and parse headers

    # Read and parse the body of the request (if applicable)

    # create the response

    # Write the response back to the socket

    client = connection.makefile("wrb")
    line = client.readline().decode("utf-8").strip()

    try:
        metoda, uri, version = line.split()
        ime = uri.split("/")[-1]
        if metoda != "GET" and metoda != "POST":
            client.write(RESPONSE_405.encode("utf8"))
        elif version != "HTTP/1.1" or not os.path.isfile("./www-data" + uri):
            client.write(RESPONSE_400.encode("utf8"))
        elif not os.path.exists("./www-data" + uri):
            pot = ".\\" + preisci_mapo(ime, "www-data")
            if pot:
                with open(pot, "rb") as h:
                    body = h.read()
                mime_type, _ = mimetypes.guess_type(pot)
                pot = pot.replace("\\", "/")
                header = RESPONSE_301 % (
                    pot[10:],
                    mime_type,
                    len(body)
                )
                client.write(header.encode("utf8"))
                client.close()
            else:
                client.write(RESPONSE_404.encode("utf"))
        elif os.path.exists("./www-data" + uri) and os.path.isfile("./www-data" + uri):
            with open(("www-data" + uri), "rb") as h:
                body = h.read()
            mime_type, _ = mimetypes.guess_type(uri)
            header = RESPONSE_200 % (
                mime_type,
                len(body)
            )
            client.write(header.encode("utf8"))
            client.write(body)
    except Exception as e:
        print(e)
        client.write(RESPONSE_400.encode("utf8"))
    client.close()


def main(port):
    """Starts the server and waits for connections."""

    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    server.bind(("", port))
    server.listen(1)

    print("Listening on %d" % port)
    while True:
        connection, address = server.accept()
        print("[%s:%d] CONNECTED" % address)
        process_request(connection, address)
        connection.close()
        print("[%s:%d] DISCONNECTED" % address)


if __name__ == "__main__":
    main(8080)

