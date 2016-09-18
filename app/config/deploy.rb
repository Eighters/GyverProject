# ==============================================================================
#                      CAPIFONY DEPLOYMENT CONFIGURATION
# ==============================================================================


# ------------------------------------------------------------------------------
# 1. Environment Config
# ------------------------------------------------------------------------------
set :stages,                %w(production staging)
set :default_stage,         "staging"
set :stage_dir,             "app/config/deploy"
require                     'capistrano/ext/multistage'


# ------------------------------------------------------------------------------
# 2. Server Config
# ------------------------------------------------------------------------------
set :application,           "GyverProject"
set :app_path,              "app"


# ------------------------------------------------------------------------------
# 3. Git Config
# ------------------------------------------------------------------------------
set :repository,            "https://github.com/TechGameCrew/GyverProject.git"
set :deploy_via,            :rsync_with_remote_cache
set :scm,                   :git
set :branch,                "master"
set :keep_releases,         3

# ------------------------------------------------------------------------------
# 4. Symfony Config
# ------------------------------------------------------------------------------
set :shared_files,          ["app/config/parameters.yml"]
set :shared_children,       [app_path + "/cache", app_path + "/logs", "vendor", "node_modules"]
set :writable_dirs,         [app_path + "/cache", app_path + "/logs"]

set :model_manager,         "doctrine"

set :use_composer,          true
set :update_vendors,        false


# ------------------------------------------------------------------------------
# 5. Other Config
# ------------------------------------------------------------------------------
# Resolve error message sudo : no tty present and no askpass program specified
default_run_options[:pty] = true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL


# ------------------------------------------------------------------------------
# 6. Capifony custom commands
# ------------------------------------------------------------------------------
before "deploy:update_code" do
  capifony_pretty_print "--> Deploying the '#{branch}' branch to '#{stage}'"
  capifony_puts_ok
end

after "deploy:update_code" do
  capifony_pretty_print "--> Install Npm dependencies"
  run "cd #{latest_release} && npm install"
  capifony_puts_ok
end

after "deploy:update_code" do
  capifony_pretty_print "--> Install Bower dependencies"
  run "cd #{latest_release} && npm run bower"
  capifony_puts_ok
end

after "deploy:update_code" do
  capifony_pretty_print "--> Compile static files with gulp"
  run "cd #{latest_release} && npm run prod"
  capifony_puts_ok
end

after "deploy:update", "deploy:cleanup"
