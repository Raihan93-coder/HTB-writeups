import requests

link = []

with open("enum_list.txt","r") as f:
    for strings in f:
        link.append(strings.strip())

for links in link:
    url = f"http://titanic.htb/{links}"
    response = requests.get(url)
    if response.status_code != 404:
        print(url)
        continue

    print("Checking...")
