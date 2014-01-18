This is our current workflow:

pages get rotated via pdftk
```sh
pdftk $file cat 1-$direction output $outpuFile
```
the pdf gets converted to tif via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -r600 -o gs-%04d.tif $pdfFile
```
blabla tifToTif
```sh
scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins-top=10 --default-margins-top=10 --content-detection=aggressive --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --threshold=1 --layout=$layout --despeckle=normal /*.tif scantailor/
```
blabla tifToHtml
```sh
tesseract $fifFile $filename -l=$lang -psm=1 hocr
```
blabla htmlToPdf
```sh
hocr2pdf -s -i $tifFile -o $filename.pdf < $htmlFile
```
blabla pdfcombine
```sh
pdftk /*.pdf output $filname
```
blabla compress
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dPDFFitPage -sPAPERSIZE=$size -dCompatibilityLevel=1.4 -dEmbedAllFonts=true -dSubsetFonts=true -sOutputFile=$newFilename $filename
```
blabla exIf
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
