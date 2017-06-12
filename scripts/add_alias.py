#!/usr/bin/env python3

import requests, sys

'''
TODO:
[ ] redirect test
'''

print("This script is to create a new alias for acmucr.org.")
route = input("Enter the route name i.e. acmucr.org/<this>: ")

default_route = "../src/AppBundle/Controller/DefaultController.php"

with open(default_route, 'r') as file:
    data = file.read()

if route in data:
    print("Route already exists")
    exit() 

url = ""
while "http://" not in url:
    url = input("Enter the url to redirect to (needs http://): ")

# deletes closing }
data = data[:-2]

with open(default_route, 'w') as file:
    file.write(data)
    file.write( """
    /**
    * @Route("/{}", name="{}")
    */
    public function {}(Request $request)
    {{
        return $this->redirect('{}');
    }}
}}""".format(route, route, route, url))

print("Created http://acmucr.org/{} which points to {}".format(route, url))
print("Now testing the url")
request = requests.get(url)
if request.status_code == 200:
    print("We good")
else:
    print("Something went wrong, go check the DefaultController")
