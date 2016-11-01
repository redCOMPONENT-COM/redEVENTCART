SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__redeventcart_billing`
(
  `id`           INT(11)        NOT NULL AUTO_INCREMENT,
  `user_id`      INT(11)        NULL DEFAULT NULL,
  `plugin`       VARCHAR(50)    NOT NULL,
  `data`         TEXT           NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rec_billing__users`
  FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE          = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT  = 1;

CREATE TABLE IF NOT EXISTS `#__redeventcart_cart`
(
  `id`         INT(11)        NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)        NULL DEFAULT NULL,
  `billing_id` INT(11)        NULL DEFAULT NULL,
  `created`    DATETIME       NOT NULL,
  `status`     VARCHAR(50)    NOT NULL DEFAULT '',
  `params`     VARCHAR(2048)  NOT NULL DEFAULT '',
  `paid`       TINYINT(1)     NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rec_cart__users`
  FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_rec_cart__redeventcart_billing`
  FOREIGN KEY (`billing_id`) REFERENCES `#__redeventcart_billing` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE          = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT  = 1;

CREATE TABLE IF NOT EXISTS `#__redeventcart_cart_participant`
(
  `id`           INT(11)        NOT NULL AUTO_INCREMENT,
  `cart_id`      INT(11)        NOT NULL,
  `session_id`   INT(11)        NULL DEFAULT NULL,
  `session_pricegroup_id`   INT(11)        NULL DEFAULT NULL,
  `attendee_id`  INT(11)        NULL DEFAULT NULL,
  `submitter_id` INT(11)        NULL DEFAULT NULL,
  `user_id`      INT(11)        NULL DEFAULT NULL,
  `params`     VARCHAR(2048)  NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rec_cart_participant__redeventcart_cart`
  FOREIGN KEY (`cart_id`) REFERENCES `#__redeventcart_cart` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_rec_cart_participant__users`
  FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE          = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT  = 1;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
