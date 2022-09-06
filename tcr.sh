#!/bin/bash

echo "Running tests..."
git add back/tests
git commit -m 'Commiting tests'
make tests-back
if [ $? -eq 0 ]; then
  git add back
  git commit -m 'Tests passed - Commited'
  echo "Tests passed - Changes commited"
else
  git checkout back
  echo "Tests not passed. Reverting!!!"
fi
