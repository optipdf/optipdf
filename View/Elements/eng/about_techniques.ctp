####Technical Information
[CakePHP](http://cakephp.org/ "cakephp project site") is a quite fast framework when caching is used.
With its bake shell it makes very fast prototyping possible and gave us an ideal base for this project.   
Pdf optimization is a time consuming task (even on a fast server).
So we decided to use a Jobserver([Gearman](http://gearman.org/ "gearman job server")), that sends you an E-Mail when the pdf is optimized.   
Thanks to [Lorenzo](https://github.com/lorenzo "Lorenzo alias jose_zap on github") for his incredible useful [cakephp-gearman](https://github.com/lorenzo/cakephp-gearman "cakephp gearman plugin") plugin.
Furthermore we have to thank the Cake-IRC Community (especially [savant](http://josediazgonzalez.com/ "savant on github") and [dereuromark](http://www.dereuromark.de/ "dereuromark")) for helping us whenever we had problems using CakePhp.
####Used Software (in order of their usage)
- Image creation: [GPL Ghostscript 9.05](http://www.ghostscript.com/ "Ghostscript, an interpreter for the PostScript language and for PDF")
- Image roatation: [PDFtk 1.44](http://www.pdflabs.com/ "PDF Labs the Producers of PDFtk")
- Text recognition: [tesseract 3.02.02](https://code.google.com/p/tesseract-ocr/ "An OCR Engine that was developed at HP Labs between 1985 and 1995... and now at Google.")
- Image compression: [scantailor enhanced Jan 6 2014](http://sourceforge.net/projects/scantailor/ "Scan Tailor is an interactive post-processing tool for scanned pages.")
- Multilayercompression and output: [pdfbeads RMagick 2.13.2](https://github.com/ifad/pdfbeads "PDFBeads is a small utility written in Ruby which takes scanned page images and converts them into a single PDF file.")
- Meta information: [exiftool 8.60](http://www.sno.phy.queensu.ca/~phil/exiftool/ "ExifTool is a platform-independent Perl library plus a command-line application for reading, writing and editing meta information in a wide variety of files.")