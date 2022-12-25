# 1- first you need to install docker if you dont have in your local system from following link apply all given pre and post steps in link:

https://docs.docker.com/engine/install/ubuntu/

# 2- setup your mysql configuration if you dont have from following link and apply all given steps in link:

https://www.digitalocean.com/community/tutorials/how-to-allow-remote-access-to-mysql

## steps to setup project
-copy .env.example file as .env in root directory
-copy docker folder as .docker in root directory
-copy docker-compose.yml.example as docker-compose.yml in root directory

# for ssl:
-set ssl_cert,ssl_key variables in .env according to your ssl certificate and key files path

# run command in terminal:
-docker-compose up -d

# open following link for runing project on browser
https://localhost:8000