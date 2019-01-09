CREATE TABLE IF NOT EXISTS `crevalle_articles`
(
  id      CHAR(36) PRIMARY KEY NOT NULL,
  title   VARCHAR(255)         NOT NULL,
  content TEXT                 NOT NULL,
  CONSTRAINT crevalle_articles_id_index
    UNIQUE (id),
  CONSTRAINT crevalle_articles_title_index
    UNIQUE (title)
);