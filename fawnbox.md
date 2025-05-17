# Reconisence using FTP(File transfer protcol)

## Summary
> This is hack the box lab machine that is used for educational purpose
> Doesn't use any encryption in this protocol thus vulnarable to many attackes
> Iam going to perform a reconisence attempt to find a particular file that is flag.txt in this system

## Impact
> As no encryption is used any attacker can perform a simple reconisence to get that file
> Thus transfer of sensitive documents with this protocol should be strictly prohibited
> Instead for more safe file transfer protocol SFTP(secure file tranfer protocol)
> This file transfer protocol incorporates Secure Shell(SSH) for authentication and data encryption

## Steps to reproduce
- Use nmap to scan the ports of the given taget ip
    ```bash
    sudo nmap -sV -v {target ip}
- After the found that port 21 is open
- Entering the system by exploiting the misconfiguration in FTP
      - Using anonymouse allows to enter the system as a legit user without the requirment of password
      - command for entering
            ```bash
              ftp {target ip}
  
