# Blacksmith

[![CircleCI](https://img.shields.io/circleci/project/github/eaperezc/blacksmith.svg?style=flat-square)]()


To see the full documentation of the library please go to:
[Blacksmith Documentation Page](https://eaperezc.github.io/blacksmith/)


PHP Command Line Interface helper library

This library is intended to help developer to create easily CLI commands using php.
It is based on the laravel artisan command but totally independent from it.

This is how the terminal looks when you run:

```{r, engine='bash', count_lines}
php blacksmith help
```

![Alt text](/resources/sc_blacksmith_help.png?raw=true "Blacksmith Help")


## Creating a Command

To create a new command, just run:

```bash
php blacksmith make:cmd hooray
```

This will create a file in `your-project/commands/Hooray.php`. If the `/commands` directory does not yet exist at the time of creating your first command, Blacksmith will automatically generate it for you.

### Organizing Commands

We recommend organizing your commands into subdirectories to keep better track of which command does what. Fortunately, this is easy to do with Blacksmith. To generate a command into a subdirectory just provide the desired path you would like the command to reside in:

```bash
php blacksmith make:cmd path/to/hooray
```

This will generate a file in the following location:

```
your-project/commands/path/to/Hooray.php
```

Even if the subdirectories you specified don't exist, they will be created automatically by Blacksmith. The ending path node `hooray` is considered the command and is where you'll be able to add your command logic.
