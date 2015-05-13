=== Terry's Commentary ===
**Contributors:** tychay    
**Donate link:** http://www.kiva.org/lender/tychay    
**Tags:** tooltip, tool-tip, commentary, tip, tips    
**Requires at least:** 2.5    
**Tested up to:** 4.2.2    
**Stable tag:** trunk    
**License:** GPLv2 or later    
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html    

Enables response/mobile-friendly text-based tooltip/commentary popups.

== Description ==

This adds a responsive and mobile-friendly tooltip popup in the vein of
[this article](http://osvaldas.info/elegant-css-and-jquery-tooltip-responsive-mobile-friendly). For an example (and an explanation why), please read
the [introductory article](http://terrychay.com/article/this-is-my-tooltip.shtml).

You can add a textual tooltip to anything simply by adding a `rel="tooltip"`
and a `title` attribute with the tooltip content, just like you'd expect with
regular HTML. It also supports shortcodes to generate them. Use the following
shortcode:
`[commentary text="INSERT TOOLTIP TEXT HERE"]INSERT TARGET TEXT HERE[/commentary]`

For backward compatibility reasons, any tags with `class="commentary" title="tooltip"` are similarly enabled.

== Installation ==

See ["Installing Plugins" article on the WP Codex](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

Once installed and activated, there's nothing more you need to do (though you
can use filters in your themes `functions.php` to change the behaviors)

== Frequently Asked Questions ==

= How do I make the fancy tooltips like the one in the [demo](http://osvaldas.info/examples/elegant-css-and-jquery-tooltip-responsive-mobile-friendly/) =

Add the following lines to your theme's `functions.php`:

```php
function you_already_know($ignore) {
    return 'fancy.css';
}
add_filter( 'tccomment_default_css', 'you_already_know' );
```

= I can style my own tooltips. I don't need the default or fancy stylesheet getting in the way. =

Add the following line to your theme's `functions.php`:

```php
add_filter( 'tccomment_add_default_css', '__return_false' );
```

The plugin's css file will no longer be loaded.

= I can't see where my tooltips are? =

The default stylesheet does not highlight tooltip targets in any way. To
highlight them in a manner common to most tooltips, go into your theme's
`style.css` and add the lines

```css
[rel~="tooltip"] {
    cursor: pointer;
    border-bottom: 1px dashed #ccc;
}
```

= Give me a shortcode button in the editor! =

Maybe. I don't use the editor. :-P

= `commentary` is too hard to spell, I want a regular `tooltip` shortcode =

By default, I didn't want to override the `tooltip` shortcode as it would
change/break ACE-based themes and other plugins that use it. If you want a
normal tooltip, add the following line to your theme's `functions.php`:

```php
add_filter( 'tccomment_add_tooltip_shortcode', '__return_true' );
```

Then you can use shortcodes in the form of `[tooltip text="target"]content[/tooltip]`. (Programmers note: this is in the `init` hook to load after theme
files and such.)

= How do I add stuff to the "theme's `functions.php` or `style.css`" =

The best way is to install [One-Click Child Theme](https://wordpress.org/plugins/one-click-child-theme/)
and make a child theme of your blog's theme. This will ensure that changes you
make will not get overwritten when the parent theme is upgraded. Then simply
navigate to `Appearance > Editor` in the WordPress admin panel. By default it
will open your theme's Stylesheet `style.css` and you can edit the
`functions.php` by clicking on `Theme Functions` on the right side.


== Screenshots ==

###1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from###
[missing image]

###2. This is the second screen shot###
[missing image]


== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
* There can only be one (first release)!

== Arbitrary section ==

This is an arbitrary section. :-)

