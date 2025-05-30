import hashlib
import base64
import sys

# contents found for the password in the .db file
lookup_hash = "5THTmJRhN7rqcO1qaApUOF7P8TEwnAvY8iXyhEBrfLyO/F2+8wvxaCYZJjRE6llM+1af"
salt = base64.b64decode("i/PjRSt4VE+L7pQA1pNtNA==")
iterations = 50000

# a custom wordlist to find the password
file_path = "/usr/share/wordlists/rockyou.txt"

with open(file_path, "r") as f:
    for word in f:

        # hashing each word form the wordlist line by line to save ram
        word = word.strip()
        gen_hash = hashlib.pbkdf2_hmac('sha256', word.encode(), salt, iterations,51)
        base64_hash = base64.b64encode(gen_hash).decode()

        # showing the status of the wordlist
        print(f"\rTrying:{word}",end="")
        sys.stdout.flush()

        # checking the generated hash with the lookup hash 
        if base64_hash == lookup_hash:
            print(f"\nPassword found: {word}")
            break
    else:
        print("\nPassword not found in list.")
