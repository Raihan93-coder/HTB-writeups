# 🐶Dog

## 🧠Summary
> The vulnarablity found is LFI (local file inclusion).
> A content managment system called as CMS backdrop is used.
> After accessing the system, I found a web-based program that runs without root privileges but still gives root access.

## 🔎Step 1 (Nmap scan)
- Did a Nmap scan to determine the open ports in the machine
  ```bash
  nmap -sV -v {ip address}
  ```
- The result of the nmap scan is  ![](./photo/nmap_scan.png)
- The ssh and http ports are open

## 🖥️Step 2 (Web enumeration)
- Used Gobuster to enumerate the webpage
  ```bash
  dirsearch -u http://dog.htb/
  ```
- 
