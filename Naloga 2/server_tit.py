"""An example of a simple HTTP server."""
import json
import mimetypes
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
HEADER_RESPONSE_200 = """HTTP/1.1 200 OK\r
content-type: %s\r
content-length: %d\r
connection: Close\r
\r
"""
HEADER_RESPONSE_301 = """HTTP/1.1 301 Moved Permanently\r
Location: %s\r
\r
<!doctype html>
<h1>301 site was moved</h1>
<p>The site was moved</p>
"""
HEADER_RESPONSE_400 = """HTTP/1.1 400 Bad request\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>400 Bad Request</h1>
\r
"""

HEADER_RESPONSE_405 = """HTTP/1.1 405 Method not allowed\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>405 Method not allowed</h1>
<p>Method is not allowed</p>
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

# Template for a 404 (Not found) error
RESPONSE_404 = """HTTP/1.1 404 Not found\r
content-type: text/html\r
connection: Close\r
\r
<!doctype html>
<h1>404 Page not found</h1>
<p>Page cannot be found.</p>
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


def parse_headers(client):
    headers = dict()
    while True:
        line = client.readline().decode("utf-8").strip()
        if not line:
            return headers
        key, value = line.split(":", 1)
        headers[key.strip()] = value.strip()


def uri_check(uri):
    uri = WWW_DATA + uri
    if uri[-1] == "/":
        if isfile(uri + "/index.html"):
            return (True, "201")
        if isdir(uri):
            return (True, "202")
    else:
        if isfile(uri):
            return (True, "200")
        if isdir(uri):
            return (True, "301")
    return (False, "404")


def uri_exists(uri):
    if isdir(uri):
        return (True, "dir")
    elif isfile(uri):
        return (True, "file")
    else:
        return (False, "404")


def guess_mime_and_length(uri):
    mime_type, _ = mimetypes.guess_type(WWW_DATA + uri)
    if mime_type == "None":
        mime_type = "application/octet-stream"
    with open((WWW_DATA + uri), "rb") as h:
        body = h.read()

    return (len(body), mime_type, body)


def process_request(connection, address, port):
    """Process an incoming socket request.

    :param connection is a socket of the client
    :param address is a 2-tuple (address(str), port(int)) of the client
    """

    try:
        client = connection.makefile("wrb")
        line = client.readline().decode("utf-8").strip()
        method, uri, version = line.split()
        headers = parse_headers(connection)
        if version != "HTTP/1.1":
            # preveri če je verzija nastavljena pravilno
            response = HEADER_RESPONSE_400
            client.write(response.encode("utf-8"))
            print(response)


        elif method != "GET" or method != "POST":
            response = HEADER_RESPONSE_405
            client.write(response.encode("utf-8"))
            print(response)


        else:
            if method == "GET":
                uri = unquote_plus(uri)
                exists, type = uri_check(uri)
                if uri[0] != "/" and len(uri) == 0:
                    response = HEADER_RESPONSE_400
                    client.write(response.encode("utf-8"))
                    print(response)


                elif uri == "/app-add":
                    response = HEADER_RESPONSE_405
                    client.write(response.encode("utf-8"))
                    print(response)


                elif exists:
                    if type == "200":
                        length, mime, body = guess_mime_and_length(uri)
                        response = HEADER_RESPONSE_200 % (mime, length)
                        client.write(response.encode("utf-8"))
                        client.write(body.encode("utf-8"))
                        print(response)
                        print(body)
                    elif type == "201":
                        length, mime, body = guess_mime_and_length(uri + "/index.html")
                        response = HEADER_RESPONSE_200 % (mime, length)
                        client.write(response.encode("utf-8"))
                        client.write(body.encode("utf-8"))
                        print(response)
                        print(body)
                    elif type == "202":
                        contents_list = FILE_TEMPLATE % ("..", "..") + "\n"
                        for el in sorted(listdir(WWW_DATA + uri)):
                            contents_list = contents_list + FILE_TEMPLATE % (el, el) + "\n"
                        body = DIRECTORY_LISTING.replace("{{CONTENTS}}", contents_list) % (uri, uri)
                        response = HEADER_RESPONSE_200 % ("text/html", len(body))
                        client.write(response.encode("utf-8"))
                        client.write(body.encode("utf-8"))
                        print(response)
                        print(body)





                else:
                    response = RESPONSE_404
            elif method == "POST":
                body = "ad"
                response = HEADER_RESPONSE_200 % ("text/html", len(body))

            client.close()

    except Exception as e:
        print(e)

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
        process_request(connection, address, port)
        connection.close()
        print("[%s:%d] DISCONNECTED" % address)


if __name__ == "__main__":
    main(8080)
