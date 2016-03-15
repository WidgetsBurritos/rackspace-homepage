#!/bin/sh
# Generates/replaces SSH key for the sshd container of the docker app.

# Create directory for SSH keys if it doesn't already exist.
mkdir -p ./certs

# Generate a SSH key
ssh-keygen -f ./certs/id_rsa -t rsa -N ''

# Copy the ssh key onto the SSH container.
cat ./certs/id_rsa.pub | ssh -p 2222 root@$(docker-machine ip) "mkdir -p ~/.ssh && cat > ~/.ssh/authorized_keys"
