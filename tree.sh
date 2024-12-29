#!/bin/bash

# Set the output file
OUTPUT_FILE="tree.txt"

# Excludes
EXCLUDES=("node_modules" "vendor" "spa/build" ".git" "tree.sh" "tree.txt" "package-lock.json" "composer.lock")
EXCLUDE_PARAMS=()
for EXCLUDE in "${EXCLUDES[@]}"; do
    # Use -path to correctly exclude directories
    EXCLUDE_PARAMS+=(-path "./$EXCLUDE" -prune -o)
done

# Use find to generate a basic tree structure and process output with sed
# Update the find command to properly handle exclusions
find ./ "${EXCLUDE_PARAMS[@]}" -print | sed -e 's;[^/]*/;|--- ;g;s;--- |;   |;g' > $OUTPUT_FILE

echo "File tree has been saved to $OUTPUT_FILE"
