# Compass config used in development

# Require any additional compass plugins here.
# require "compass-growl"

$:.unshift File.join(File.dirname(__FILE__))
require "sprite_methods_monkey_patches"

sass_dir = "./"
css_dir = "./compiled"

images_dir = "web/assets/images"
javascripts_dir = "web/assets/js"

sprite_load_path = "web/assets/images/sprites/"
generated_images_dir = "web/assets/images/sprites/generated"

http_path = "/"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :expanded

# Enable relative paths to assets via compass helper functions.
relative_assets = true

# Debug comments that display the original location of your selectors.
line_comments = true
