#!/bin/bash
#extract basename of pdf in $name
name=`basename "$1" .pdf`
echo "$name"
echo $1;
mkdir ."$name"_tmp
gs -sDEVICE=tiffg4 -r600x600 -dNOPAUSE -dBATCH -dSAFER -sOutputFile=."$name"_tmp/"$name"-%04d.tif $1
cd ."$name"_tmp
mkdir ."$name"_tmp2
mv *.tif ."$name"_tmp2/
scantailor-cli -v --enable-page-detection --content-detection=aggressive --normalize-illumination --dewarping=auto ."$name"_tmp2/*.tif .
rm -r ."$name"_tmp2 
rm -r cache
for f in *.tif
do 
tempname=`basename "$f" .tif`
tesseract "$f" "$tempname" -l deu hocr
done
for f in *tif
do
tempname=`basename "$f" .tif`
hocr2pdf -i "$f" -o "$name"_optimized.pdf < "$tempname".html
done
convert -compress JBIG2 -density 100 "$name"_optimized.pdf "$name"_optimized.pdf
cd ..
rm -r ."$name"_tmp
exit
