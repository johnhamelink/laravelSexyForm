<?php

/*
 * Copyright (c) 2012, John Hamelink
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of John Hamelink nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL JOHN HAMELINK BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */



/**
 * FormHelper
 *
 * This class is used to ensure we keep forms in the same
 * format, no matter where they're used in the application.
 *
 * It also ensures we show the errors in the correct place, without
 * messing up our code.
 *
 *
 */
class FormHelper {

    /**
     * If we have errors, display them inside a span with class "error"
     *
     * @param $errors Object
     * @param $safeName   String
     * @param $prefix String
     * @param $suffix String
     *
     * @return String
     */
    public static function errors(&$errors, $safeName, $prefix="<span class='errorText'>", $suffix="</span>") {
        if ( $errors !== null && count($errors) > 0 && $errors->has($safeName)) {
            return $prefix . $errors->first($safeName) . $suffix;
        } else {
            return "";
        }
    }

    /**
     * Encapsulate our label in a prefix
     *
     * @param $name     String
     * @param $safeName String
     * @param $prefix   String
     * @param $suffix   String
     *
     * @return String
     */
    public static function label($name, $value, $prefix="<td>", $suffix="</td>") {
        return $prefix . Form::label($name, $value) . $suffix;
    }

    /**
     * Clean the label string into something more POSTable (AKA sanitized &
     * camelCase).
     *
     * @param $name String
     *
     * @return String
     */
    public static function safeName($name) {
        // Make the String pure ASCII
        $name = preg_replace( '/[\x7f-\xff]/', '', $name );
        // Replace any hyphens with spaces
        $name = str_replace(array('-', '_'), ' ', $name);
        // Uppercase all words
        $name = ucwords($name);
        // Make sure the first letter is lowercase
        $name = strtolower(substr($name,0,1)) . substr($name,1);
        // Remove all chars apart from words and numbers
        $name = preg_replace('/[^\w\d]/','',$name);
        return $name;
    }

    /**
     * Create a text field, complete with errors, label and textbox
     *
     * @param $name String
     * @param $errors Object
     * @param $value String
     * @param $prefix String
     * @param $suffix String
     *
     * @return String
     */
    public static function text($name, &$errors = null, $value = null, $prefix="<td>", $suffix="</td>") {
        // If a name is set, use it, otherwise generate a safe name!
        if (!is_array($name)) {
            $safeName = FormHelper::safeName($name);
        } else {
            $safeName = $name[0];
            $name = $name[1];
        }

        // Rewrite default data with old flash-data
        // if it exists.
        if (Input::old($safeName)) {
            $value = Input::old($safeName);
        }

        $prefix = FormHelper::errors($errors, $safeName) .
                  FormHelper::label($safeName, $name) .
                  $prefix;

        return $prefix . Form::text($safeName, $value) . $suffix;
    }

    /**
     * Create a textArea, complete with errors, label and textbox
     *
     * @param $name String
     * @param $errors Object
     * @param $value String
     * @param $prefix String
     * @param $suffix String
     *
     * @return String
     */
    public static function textArea($name, $errors = null, $value = null, $prefix="<td>", $suffix="</td>") {
        // If a name is set, use it, otherwise generate a safe name!
        if (!is_array($name)) {
            $safeName = FormHelper::safeName($name);
        } else {
            $safeName = $name[0];
            $name = $name[1];
        }

        // Rewrite default data with old flash-data
        // if it exists.
        if (Input::old($safeName)) {
            $value = Input::old($safeName);
        }

        $prefix = FormHelper::errors($errors, $safeName) .
                  FormHelper::label($safeName, $name) .
                  $prefix;

        return $prefix . Form::textarea($safeName, $value) . $suffix;
    }

    /**
     * Create a password, complete with errors, label and textbox
     *
     * @param $name String
     * @param $errors Object
     * @param $prefix String
     * @param $suffix String
     *
     * @return String
     */
    public static function password($name, $errors = null, $prefix="<td>", $suffix="</td>") {
        if (!is_array($name)) {
            $safeName = FormHelper::safeName($name);
        } else {
            $safeName = $name[0];
            $name = $name[1];
        }


        $prefix = FormHelper::errors($errors, $safeName) .
                  FormHelper::label($safeName, $name) .
                  $prefix;

        return $prefix . Form::password($safeName) . $suffix;
    }
}
