#!/bin/bash
if [[ ! -d "/home/gfuser/app/node_modules" ]]
then
  npm install
fi
npm run dev
