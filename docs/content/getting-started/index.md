---
date: 2016-12-13T21:19:44-05:00
title: Getting Started
---

Lets get started using blacksmith. The main idea here is to get you to through the installation process of the script in any project you want to add it and give you the basic usage on how you can use your commands.


## Installation


The first thing we need to do is to get Blacksmith. To do that you can go to the github repository and download it manually but if course we think the best way to include it would be using composer. So thats what we are going to do:

```sh
composer require eaperezc/blacksmith
```

## Bootstrap

After composer finished downloading the library, you will have it on your vendor folder inside of the bin folder. Of course you could access it using that file but we think is easier of you have it on the root folder. If you copy and paste the blackmith file manually it would work of course but to bootstrap we created a helper command you can run:


```sh
./vendor/bin/blacksmith bootstrap
# The commands folder and the blacksmith script will be available to use
```

## Help

Any command that is available it will automatically appear in the help section of blacksmith. To see the help you just type the following:

```sh
php blacksmith
# Or php blacksmith help also works
```

## Usage

You'll see that the way we can call any command using blacksmith is the one that we see in the help menu. Of course each command works differently and some of them wont have the need of arguments. See the example:

```sh
php blacksmith [signature] [arguments]

# Example:
php blacksmith make:cmd ExampleCommand
```

I will continue to add more documentation here as soon as we have more things to show. Specially on how to create custom commands and register them in blacksmith. Have a good one!



