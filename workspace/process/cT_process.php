<?php
    $cT_process = array(
        'CREATE TABLE `comments` (
        `id` int(10) NOT NULL,
        `topic_id` int(11) NOT NULL,
        `date` date NOT NULL,
        `user` varchar(10) NOT NULL,
        `value` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
        'CREATE TABLE `tags` (
            `topic_id` varchar(10) NOT NULL,
            `value` varchar(10) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
        'CREATE TABLE `topic` (
            `id` int(10) NOT NULL,
            `date` date NOT NULL,
            `user_id` varchar(10) NOT NULL,
            `content` text NOT NULL,
            `mode` char(2) NOT NULL,
            `importance` int(1) DEFAULT NULL,
            `resolved` char(1) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;',
        'CREATE TABLE `users` (
            `user_id` varchar(10) NOT NULL,
            `name` varchar(20) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
          ,
          'ALTER TABLE `comments`
          ADD PRIMARY KEY (`id`);',
          'ALTER TABLE `tags`
          ADD PRIMARY KEY (`topic_id`,`value`);',
          'ALTER TABLE `topic`
          ADD PRIMARY KEY (`id`);',
          'ALTER TABLE `users`
          ADD PRIMARY KEY (`user_id`);',
          'ALTER TABLE `comments`
          MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;',
          'ALTER TABLE `topic`
          MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
        '

    );
    
?>