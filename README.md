
Good Shelf (yes, it's a stupid name)
====================================


Good SHelf is a basic plugin that allows the user to add a GoodReads.com shelf to their wordpress blog.

It was created so that I could display the books that i'm currently reading, 
either displaying the book cover images, the title of the book or both.


Usage
-----

upload the good_shelf.php file to your 'wp-content/plugins' folder.
In the 'appearance > widgets' page of your wordpress admin, drag and drop the Goodshelf widget into your widgets area.

Settings
--------

The title option is self explanatory.

The 'Gooodreads ID' option is your goodreads ID. It can be found if you go to the 'profile' section,
under where it says 'hi YOUR USERNAME'. Once the page has loaded your ID is the characters after 'show'.
e.g. in 'http://www.goodreads.com/user/show/1234567', '1234567' would be your ID.
The defualt ID is my Goodreads ID. Change this, unless you want to display my excellent taste in books.

The 'shelf' dropdown is where you select you shelf. If it's only displaying 'currently Reading', 'to-read' and 'read' shelves
it's because you have to save your widget. The forementioned shelves are the defualt shelves that all Goodreads users start with.
After you have saved your settings, your shelves should appear in the dropdown.

The 'display as' option is where you select how you want the books to be displayed.
'Cover art' wil display cover images.
'link list' will display your books as links in an unordered list.


Styling
--------

The link list items can be styled with in your CSS file with 'ul.goodreads li'.
The cover art can be styled with '.goodreads_image'.
The 'Provided by Goodreads' can be styled using 'p.goodreads_power'.



Important Information
---------------------

You must keep the link to goodreads.com because it is stated in their terms of service.
Please don't take this code and try to fob it off as your own. I'm giving away from the goodness of my heart.
If you wish to contribute then by all means send me a clone request on github:
https://github.com/sneakatron/Good-Shelf