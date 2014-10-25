#! /bin/bash

# generates from a to b icons

function get_id() {
    network="$1";
    if [ "$network" == "google" ]; then
        echo "0";
    elif [ "$network" == "facebook" ]; then
        echo "1";
    elif [ "$network" == "flickr" ]; then
        echo "2";
    elif [ "$network" == "instagram" ]; then
        echo "3";
    else
        echo "x";
    fi
}

for a in facebook google flickr instagram unknown;
do
    for b in facebook google flickr instagram unknown;
    do
        if [ "$a" != "$b" ]; then
            convert "$a-icon-32.png" "arrow_right.png" "$b-icon-32.png" +append /tmp/image.png
            mv /tmp/image.png "$(get_id $a)-to-$(get_id $b)-icon.png"
        fi
    done
done
echo "done :)"