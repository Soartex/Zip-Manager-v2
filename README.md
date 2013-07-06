Zip-Manager-v2
==============

The zip manager is a direct solution to syncing the soartex file server with the github textures repo. It links into the staff system, and also links in with the patcher config files.

The manager pulls all data from the /data/options.json. This file contols what the zipmanager is capable of. It has the presets that the zipmanager uses to do its task.

How it works:
* Pulls Files from github
* Uploads them to the local server
* Zips the file

Things that the Zip Manager can do
* Add and remove zip files
* Update patcher config per zip file
* Sync with github
* Works on a per branch or repo basis
* Allows for easy back dating of mods 
* Managment of the patcher system
