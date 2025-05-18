# Reconisence using FTP(File transfer protcol)

## Summary
> This is hack the box lab machine that is used for educational purpose.
> This protocol doesn't use any encryption thus vulnarable to many attackes.
> Iam going to perform a reconisence attempt to find a particular file that is flag.txt in this system

## Impact
> As no encryption is used any attacker can perform a simple reconisence to get that file.
> Thus transfer of sensitive documents with this protocol should be strictly prohibited.
> Instead for more safe file transfer protocol SFTP(secure file tranfer protocol).
> This file transfer protocol incorporates Secure Shell(SSH) for authentication and data encryption

## Steps to reproduce
- Use nmap to scan the ports of the given taget ip
    ```bash
    sudo nmap -sV -v {target ip}
    ```
    - The command -sV is given to get the version of the service thus to find the vulareblity we can exploit
    - -v command is used to get a verbose output not typically necessary
- After that found that port 21 is open
- Entering the system by exploiting the misconfiguration in FTP
- Using anonymouse ,allows you to enter the system as a legit user without the requirment of password
- command for entering
    ```bash
     ftp {target ip}
    ```
- Enter anonymouse and then any password of your choice which allows you access to FTP shell
- Then to find the directory and navigate the directory using
    ```bash
    ls
    cd {dir}
- After that find the file that is required in this case flag.txt
- After finding use
  ```bash
  get flag.txt
- The file will be then downloaded and stored in your system
- veiw the contents of the file in your system by typing
  ```bash
  cat flag.txt

 ## Recomended fixes
 > Use SFTP for more secure file transfer
 > Patch up the insecurity of anonymouse login into the system
