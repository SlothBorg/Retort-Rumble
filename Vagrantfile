# -*- mode: ruby -*-
# vi: set ft=ruby :
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"

  # Create a forwarded port mapping which allows access to a specific port
  # via 127.0.0.1 to disable public access
  config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  config.vm.network "private_network", ip: "192.168.56.105"

  # Share an additional folder to the guest VM.
  config.vm.synced_folder ".files/site", "/var/www/retortrumble"
  config.vm.synced_folder ".files/setup", "/var/www/setup"
  config.vm.synced_folder ".provision", "/var/www/provision"

  config.vm.provider "virtualbox" do |vb|
    # Customize the amount of memory on the VM:
    vb.memory = "1024"
    vb.name = "RetortRumble"
  end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available.
  config.vm.provision :shell, :path => ".provision/bootstrap.sh"
end
