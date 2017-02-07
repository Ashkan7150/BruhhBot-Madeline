<?php
/**
    Copyright (C) 2016-2017 Hunter Ashton

    This file is part of BruhhBot.

    BruhhBot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    BruhhBot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with BruhhBot. If not, see <http://www.gnu.org/licenses/>.
 */
function catch_id($update, $MadelineProto, $user)
{
    $first_char = substr($user, 0, 1);
    if (is_numeric($user)) {
        $user_ = cache_get_info($update, $MadelineProto, $user);
        if ($user_) {
            if (array_key_exists(
                'username', $user_['User']
            )
            ) {
                $username = $user_['User']['username'];
            } else {
                $username = $user_['User']['first_name'];
            }
            $userid = $user_['bot_api_id'];
            return array(true, $userid, $username);
        } else {
            return array(false);
        }
    }
    if (preg_match_all('/@/', $first_char, $matches)) {
        $user_ = cache_get_info($update, $MadelineProto, $user);
        if ($user_) {
            if (array_key_exists(
                'username', $user_['User']
            )
            ) {
                $username = $user_['User']['username'];
            } else {
                $username = $user_['User']['first_name'];
            }
            $userid = $user_['bot_api_id'];
            return array(true, $userid, $username);
        } else {
            return array(false);
        }
    } else {
        if (array_key_exists('entities', $update['update']['message'])) {
            foreach ($update['update']['message']['entities'] as $key) {
                if (array_key_exists('user_id', $key)) {
                    $userid = $key['user_id'];
                    $username = cache_get_info($update, $MadelineProto, $user)['User']['first_name'];
                    break;
                }
            }
        }
        if (isset($userid)) {
            return array(true, $userid, $username);
        } else {
            return array(false);
        }
    }
}