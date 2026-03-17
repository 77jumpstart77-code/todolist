@echo off
set SSH_KEY="C:\Users\notebiz004\Desktop\SSHkey.pem"
set REMOTE_USER=bitnami
set REMOTE_IP=15.165.116.71
set REMOTE_DIR=/opt/bitnami/apache/htdocs/todo

echo [1/3] Creating remote directory...
ssh -i %SSH_KEY% %REMOTE_USER%@%REMOTE_IP% "sudo mkdir -p %REMOTE_DIR% && sudo chown %REMOTE_USER%:%REMOTE_USER% %REMOTE_DIR%"

echo [2/3] Uploading files...
scp -i %SSH_KEY% index.html api.php db.php %REMOTE_USER%@%REMOTE_IP%:%REMOTE_DIR%/

echo [3/3] Initializing Database (Run this manually on the server or via SSH)...
echo Please run: mysql -u root -p < init.sql on the server.
echo.
echo Deployment Complete! Visit http://%REMOTE_IP%/todo
pause
