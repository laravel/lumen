# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "tsihosting/centos7"
  config.vm.box_check_update = true

  config.vm.hostname = "fancensus-project"

  config.vm.provider "virtualbox" do |vb|
    vb.name = "fancensus-project"
    vb.memory = 256
    vb.cpus = 1
  end

  config.vm.provision "shell", path: "bootstrap.sh"
end