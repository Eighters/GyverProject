# ==============================================================================
#                                CONFIGURATION
# ==============================================================================

# ------------------------------------------------------------------------------
# 1. Servers config
# ------------------------------------------------------------------------------
set :application, "%server_project_name%"
set :domain,      "%server_address%"
set :user,        "%server_user%"
set :deploy_to,   "%server_project_path%"
set :app_path,    "app"
role :web,        domain
role :app,        domain, :primary => true

# ------------------------------------------------------------------------------
# 2. Git config
# ------------------------------------------------------------------------------
set :repository,        "git@github.com:TechGameCrew/GyverProject.git"
set :scm,               :git
set :deploy_via,        :copy
set :keep_releases,     5

# ------------------------------------------------------------------------------
# 3. Symfony config
# ------------------------------------------------------------------------------
set :shared_files,      ["app/config/parameters.yml"]
set :writable_dirs,     ["app/cache", "app/logs"]
set :model_manager,     "doctrine"

set :use_composer,      true
set :update_vendors,    false
set :use_sudo,          false

# set :dump_assetic_assets, true

# ------------------------------------------------------------------------------
# 3. Other config
# ------------------------------------------------------------------------------
# Resolve error message sudo : no tty present and no askpass program specified
default_run_options[:pty] = true

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL
