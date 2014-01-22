This is the new beta-workflow
===============================
#Pages get rotated via pdftk if needed
```sh
pdftk $file cat 1-$direction output $outputFile
```
#The pdf gets converted to single tifs via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiff24nc -r600 -o gs-%04d.tif $pdfFile
```
#Single tifs get unpapered by scantailor-cli
```sh
scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins=5 --default-margins=5 --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=$colormode --threshold=1 --layout=$layout --despeckle=normal *.tif scantailor/
```
#Text Recognition by tesseract
```sh
tesseract $fifFile $filename -l=$lang -psm=1 hocr
```
#JBIG2-Compression
```sh
jbig2 -p -s -2 -O $outpng $intif
```
#Merge html and png to Sandwich-Pdf
```sh
//?? for i in *.png; do hocr2pdf -s -i $i -o ${i%%.*}.pdf < ${i%%.*}.html; done
hocr2pdf -s -i $pngFile -o $filename.pdf < $htmlFile
```
#Combine Sandwich-Pdf to Master-Pdf
```sh
pdftk /*.pdf output $filname
```
#Write Exif-Info
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
