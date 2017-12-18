library(lubridate)
library(rstudioapi)


#' Create a new article from a template
#'
#' @param site_root Local directory holding the website. Defaults til website
#' @param title Not yet used
#' @param slug  Slug of the article which will become the directory name
#' @param date  Not yet used
#'
#' @return
#' @export
#'
#' @examples
new_article <- function(slug, title = slug, date = lubridate::today(), site_root = "website") {
  dir.create(paste0(site_root, "/articles/", slug))
  new_file <- paste0(site_root, "/articles/", slug, "/", "index.php")
  file.copy("template/article.php", new_file)
  rstudioapi::navigateToFile(paste0(site_root, "/articles/index.php"), line = 14, column = 1)
  rstudioapi::navigateToFile(new_file, line = 11, column = 10)
}

#' Upload the web site
#'
#' @param remote_path Path on the server holding the website. Defaults to global variable REMOTE_PATH
#' @param site_root   The name of the local directory holding the website. Defaults to "website"
#'
#' @return
#' @export
#'
#' @examples
upload_website <- function(remote_path = REMOTE_PATH, site_root = "website") {
  old_wd <- getwd()
  setwd(site_root)
  system(paste0("rsync -v -r -a ./ ", remote_path))
  setwd(old_wd)
}