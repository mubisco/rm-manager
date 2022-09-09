#!/bin/bash

TEST_COMMAND='make tests-back'
TEST_FOLDER_PATH='back/tests'
SRC_FOLDER_PATH='back'

echo "Running tests..."
git add ${TEST_FOLDER_PATH}
git commit -m 'Commiting tests'
${TEST_COMMAND}
if [ $? -eq 0 ]; then
  git add ${SRC_FOLDER_PATH}
  git commit -m 'Tests passed - Commited'
  echo "Tests passed - Changes commited"
else
  git checkout ${SRC_FOLDER_PATH}
  echo "Tests not passed. Reverting!!!"
fi
