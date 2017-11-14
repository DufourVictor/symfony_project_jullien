# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'
current_dir    = File.dirname(File.expand_path(__FILE__))
config     = YAML.load_file("#{current_dir}/app/config/smart.yml")

ip = config['parameters']['vagrant_ip']
name = config['parameters']['project_name']
url = config['parameters']['project_url']
db_password = config['parameters']['vagrant_db_password']

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.box_check_update = false

  config.vm.network "forwarded_port", guest: 80, host: 8011
  config.vm.network "forwarded_port", guest: 3306, host: 3311
  config.vm.network "private_network", ip: ip

  config.vm.synced_folder ".", "/var/www", type: "nfs", :linux__nfs_options => ["rw","no_root_squash","no_subtree_check"], nfs_version: "4", nfs_udp: false

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "1024"
  end

  config.vm.provision "file", source: "./deploy/apache/project.conf", destination: "/var/www/project.conf"
  config.vm.provision "file", source: "./deploy/apache/apache2.conf", destination: "/var/www/apache2.conf"
  config.vm.provision "file", source: "./deploy/mysql/my.cnf", destination: "/var/www/my.cnf"
  config.vm.provision "file", source: "./deploy/phpmyadmin/config.inc.php", destination: "/var/www/config.inc.php"
  config.vm.provision "file", source: "./deploy/phpmyadmin/apache.conf", destination: "/var/www/apache.conf"
  config.vm.provision "shell", path: "./deploy/script.sh", args: [ip, name, url, db_password]
end
