#!/bin/sh

echo start_up
sleep 5
mc alias set myminio http://minio:9000 ${MINIO_ROOT_USER} ${MINIO_ROOT_PASSWORD};
mc mb myminio/${MINIO_BUCKET_NAME};
mc anonymous set public myminio/${MINIO_BUCKET_NAME};
mc anonymous set download myminio/${MINIO_BUCKET_NAME};
exit 0
