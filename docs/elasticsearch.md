# LaraSearch Documentation

## Elasticsearch Installation

In addition to the PHP packages, you must also install Elasticsearch onto your server. The following guide will take you through step-by-step to install Java 8 and Elasticsearch 5. These instructions assume you have command line access to a Debian based Linux distribution.

## Installing Java

Elasticsearch depends on Java, so the first thing we will do is install it. First will will add the repository:

```bash
sudo add-apt-repository -y ppa:webupd8team/java
```

and then we will install it:

```bash
sudo apt-get update
sudo apt-get -y install oracle-java8-installer
```

You may be asked to accept some licensing agreements. If you agree, select yes. The installer will run, and then Java 8 installation will be complete!

## Installing Elasticsearch

First we will add the Elasticsearch GPG key:

```bash
wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
```

Next we will add the repository to our source list:

```bash
echo "deb https://artifacts.elastic.co/packages/5.x/apt stable main" | sudo tee -a /etc/apt/sources.list.d/elastic-5.x.list
```

Now we will install Elasticsearch:

```bash
sudo apt-get update
sudo apt-get install elasticsearch
```

If you choose, you may also add Elasticsearch to your startup scripts, so it is automatically started when you reboot your machine.

```bash
sudo update-rc.d elasticsearch defaults 95 10
```

## Configuring Elasticsearch

Open up you Elasticsearch configuration file:

```bash
sudo vim /etc/elasticsearch/elasticsearch.yml
```

While there are many, many configuration options available to you, there are only two we will change right now. `cluster.name`. is used to designate which machine Elasticsearch is running on. If you are testing this on your Homestead environment, one option would be to use 'homestead' here. `network.host` tells Elasticsearch what application are allowed to connect to it. Often times, you are simply running on localhost, so `127.0.0.1` is a good option.

## Testing Elasticsearch

Finally let's use a simple CURL request to make sure Elasticsearch was installed correctly.

```bash
curl -X GET 'http://localhost:9200'
```

If Elasticsearch was installed correctly, you will see a message similar to the following:

```bash
{
  "name" : "YZkrpNG",
  "cluster_name" : "homestead",
  "cluster_uuid" : "Zk3fqZbsRdKYNaSzL3-9pQ",
  "version" : {
    "number" : "5.4.0",
    "build_hash" : "780f8c4",
    "build_date" : "2017-04-28T17:43:27.229Z",
    "build_snapshot" : false,
    "lucene_version" : "6.5.0"
  },
  "tagline" : "You Know, for Search"
}
```

## Next Steps

Now that Elasticsearch is installed, you can continue on with the LaraSearch [SETUP](readme.md).
