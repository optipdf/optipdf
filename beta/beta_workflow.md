This could be the next workflow
===============================
#Pages get rotated via pdftk
```sh
pdftk $file cat 1-$direction output $outpuFile
```
#The pdf gets converted to single tifs via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiff24nc -r600 -o gs-%04d.tif $pdfFile
```
#Single tifs get unpapered by scantailor-cli
```sh
for i in *.tif; do scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins-top=10 --default-margins-top=10 --content-detection=aggressive --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=black_and_white|color_grayscale|mixed --threshold=1 --layout=$layout --despeckle=normal $i scantailor/; done
```
#Text Recognition by tesseract
```sh
// for i in *.tif; do tesseract $i ${i%%.*} -l=eng -psm=1 hocr; done
tesseract $fifFile $filename -l=$lang -psm=1 hocr
```
#JBIG2-Compression
```sh
// for i in *.tif; do jbig2 -p -s -2 -O ${i%%.*}.png $i; done
jbig2 -p -s -2 -O $outpng $intif
```
#Merge html and jpg to Sandwich-Pdf
```sh
// for i in *.png; do hocr2pdf -s -i $i -o ${i%%.*}.pdf < ${i%%.*}.html
hocr2pdf -s -i $tifFile -o $filename.pdf < $htmlFile
```
#Combine Sandwich-Pdf to Master-Pdf
```sh
pdftk /*.pdf output $filname
```
#Write Exif-Info
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
