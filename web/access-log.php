<?php

file_put_contents("user-agent.log", "$_SERVER[HTTP_USER_AGENT] - " . date('Y-m-d H:i.s') . "\n", FILE_APPEND);