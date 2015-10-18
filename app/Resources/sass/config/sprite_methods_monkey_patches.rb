# monkey patch cleanup_old_sprites to remove old sprites when
# generated_images_path is set
# https://github.com/chriseppstein/compass/commit/d2e44b8125f60ccdf42e7f00cb2df83b06644c6e

module Compass::SassExtensions::Sprites::SpriteMethods
  def cleanup_old_sprites
    Dir[File.join(Compass.configuration.generated_images_path, "#{path}-s*.png")].each do |file|
      log :remove, file
      FileUtils.rm file
      Compass.configuration.run_sprite_removed(file)
    end
  end
end
