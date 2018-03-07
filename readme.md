# pgp_server


## How to Setup

### Database
    CREATE SCHEMA pgp DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    

https://docs.bigchaindb.com/projects/server/en/latest/quickstart.html




## How to Start
sudo mkdir -p /data/db

sudo chmod -R 700 /data/db

sudo mongod --replSet=bigchain-rs

-- bigchaindb -y configure mongodb

bigchaindb start

http://127.0.0.1:9984/