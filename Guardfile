# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'bundler' do
  watch('Gemfile')
  # Uncomment next line if Gemfile contain `gemspec' command
  # watch(/^.+\.gemspec/)
end

guard 'less', :output => 'web/css/', :all_on_start => true, :all_after_change => true do
  #watch(%r{^.+\.less$})
  watch(%r{^build/css/(.+\.less)$})
end

#guard 'livereload' do
  # watch(%r{app/views/.+\.(erb|haml|slim)$})
  # watch(%r{app/helpers/.+\.rb})
  # watch(%r{public/.+\.(css|js|html)})
  # watch(%r{config/locales/.+\.yml})
  # Rails Assets Pipeline
  # watch(%r{(app|vendor)(/assets/\w+/(.+\.(css|js|html))).*}) { |m| "/assets/#{m[3]}" }
#end
