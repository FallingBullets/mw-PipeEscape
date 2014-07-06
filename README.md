mw-PipeEscape
=============

A git mirror of the [svn repository](http://svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/PipeEscape/)

See the [MediaWiki page](http://www.mediawiki.org/wiki/Extension:Pipe_Escape) for instalation and usage detail.


This mirror also contains a second parser function `{{#?:n|...}}` which returns the first n (0+) passed arguments. For example `{{#?:3|a|b|c|d|e}}` returns `a|b|c` and `{{#?:0|a|b|c}}` returns nothing, {{#?:-2|a|b|c|d}} returns `c|d`. 
