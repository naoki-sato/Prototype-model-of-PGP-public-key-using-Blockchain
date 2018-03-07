# -*- coding: utf-8 -*-
from bigchaindb_driver import BigchainDB
from bigchaindb_driver.crypto import generate_keypair
from time import sleep
from sys import exit
import sys

# 簡易チェック
argvs = sys.argv
if (len(argvs) != 3):   # 引数が足りない場合は，プログラムの終了
    print ('Usage: # python3 %s <UserID> <Ascii_Armored>' % argvs[0])
    quit()


# 暗号ペア生成
pgp = generate_keypair()

bdb = BigchainDB('http://127.0.0.1:9984')

# アセット定義
pgp_public_asset = {
    'data': {
        'pgp_public_key': {
            'UserID': argvs[1],
            'Ascii_Armored': argvs[2]
        },
    },
}

# Assetクリエーション
# RDBのレコードの代わりにbigchainではtransaction単位でデータが保存される。
# transactionの用意をしている。
prepared_creation_tx = bdb.transactions.prepare(
    operation='CREATE',
    signers=pgp.public_key,
    asset=pgp_public_asset
)

# トランザクションは、秘密鍵で署名することで実現する必要がる。
fulfilled_creation_tx = bdb.transactions.fulfill(
    prepared_creation_tx,
    private_keys=pgp.private_key
)

# BigchainDBノードに送信！！！
sent_creation_tx = bdb.transactions.send(fulfilled_creation_tx)

txid = fulfilled_creation_tx['id']

# トランザクションが有効になるまでトランザクションのステータスをチェックし続ける
trials = 0
while trials < 60:
    try:
        if bdb.transactions.status(txid).get('status') == 'valid':
            print('Tx valid in:', trials, 'secs')
            break
    except bigchaindb_driver.exceptions.NotFoundError:
        trials += 1
        sleep(1)

if trials == 60:
    print('Tx is still being processed... Bye!')
    exit(0)