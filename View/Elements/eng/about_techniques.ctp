####Technical Information
[CakePHP](http://cakephp.org/ "cakephp project site") is a quite fast framework when caching is used.
With its bake shell it makes very fast prototyping possible and gave us an ideal base for this project.   
Pdf optimization is a time consuming task (even on a fast server).
So we decided to use a Jobserver([Gearman](http://gearman.org/ "gearman job server)), that sends you an E-Mail when the pdf is optimized.   
Thanks to [Lorenzo](https://github.com/lorenzo "Lorenzo alias jose_zap on github") for his incredible useful [cakephp-gearman](https://github.com/lorenzo/cakephp-gearman "cakephp gearman plugin") plugin.
Furthermore we have to thank the Cake-IRC Community (especially [savant](http://josediazgonzalez.com/ "savant on github") and [dereuromark](http://www.dereuromark.de/ "dereuromark")) for helping us whenever we had problems using CakePhp.
