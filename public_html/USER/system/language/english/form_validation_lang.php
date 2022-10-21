<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/*
$lang['form_validation_required']		= 'The {field} field is required.';
$lang['form_validation_isset']			= 'The {field} field must have a value.';
$lang['form_validation_valid_email']		= 'The {field} field must contain a valid email address.';
$lang['form_validation_valid_emails']		= 'The {field} field must contain all valid email addresses.';
$lang['form_validation_valid_url']		= 'The {field} field must contain a valid URL.';
$lang['form_validation_valid_ip']		= 'The {field} field must contain a valid IP.';
$lang['form_validation_valid_base64']		= 'The {field} field must contain a valid Base64 string.';
$lang['form_validation_min_length']		= 'The {field} field must be at least {param} characters in length.';
$lang['form_validation_max_length']		= 'The {field} field cannot exceed {param} characters in length.';
$lang['form_validation_exact_length']		= 'The {field} field must be exactly {param} characters in length.';
$lang['form_validation_alpha']			= 'The {field} field may only contain alphabetical characters.';
$lang['form_validation_alpha_numeric']		= 'The {field} field may only contain alpha-numeric characters.';
$lang['form_validation_alpha_numeric_spaces']	= 'The {field} field may only contain alpha-numeric characters and spaces.';
$lang['form_validation_alpha_dash']		= 'The {field} field may only contain alpha-numeric characters, underscores, and dashes.';
$lang['form_validation_numeric']		= 'The {field} field must contain only numbers.';
$lang['form_validation_is_numeric']		= 'The {field} field must contain only numeric characters.';
$lang['form_validation_integer']		= 'The {field} field must contain an integer.';
$lang['form_validation_regex_match']		= 'The {field} field is not in the correct format.';
$lang['form_validation_matches']		= 'The {field} field does not match the {param} field.';
$lang['form_validation_differs']		= 'The {field} field must differ from the {param} field.';
$lang['form_validation_is_unique'] 		= 'The {field} field must contain a unique value.';
$lang['form_validation_is_natural']		= 'The {field} field must only contain digits.';
$lang['form_validation_is_natural_no_zero']	= 'The {field} field must only contain digits and must be greater than zero.';
$lang['form_validation_decimal']		= 'The {field} field must contain a decimal number.';
$lang['form_validation_less_than']		= 'The {field} field must contain a number less than {param}.';
$lang['form_validation_less_than_equal_to']	= 'The {field} field must contain a number less than or equal to {param}.';
$lang['form_validation_greater_than']		= 'The {field} field must contain a number greater than {param}.';
$lang['form_validation_greater_than_equal_to']	= 'The {field} field must contain a number greater than or equal to {param}.';
$lang['form_validation_error_message_not_set']	= 'Unable to access an error message corresponding to your field name {field}.';
$lang['form_validation_in_list']		= 'The {field} field must be one of: {param}.';
*/

$lang['form_validation_required']		= '{field} 필드는 필수입니다.';
$lang['form_validation_isset']			= '{field} 필드에는 값이 있어야합니다.';
$lang['form_validation_valid_email']		= '{field} 필드는 유효한 이메일 주소를 포함해야합니다.';
$lang['form_validation_valid_emails']		= '{field} 필드에는 유효한 모든 이메일 주소가 포함되어야합니다.';
$lang['form_validation_valid_url']		= '{field} 필드는 유효한 URL을 포함해야합니다.';
$lang['form_validation_valid_ip']		= '{field} 필드는 유효한 IP를 포함해야합니다.';
$lang['form_validation_valid_base64']		= '{field} 필드는 유효한 Base64 문자열을 포함해야합니다.';
$lang['form_validation_min_length']		= '{field} 필드는 길이가 {param} 자 이상이어야합니다.';
$lang['form_validation_max_length']		= '{field} 필드는 길이가 {param}자를 초과 할 수 없습니다.';
$lang['form_validation_exact_length']		= '{field} 필드는 길이가 정확히 {param} 자 여야합니다.';
$lang['form_validation_alpha']			= '{field} 필드는 알파벳 문자 만 포함 할 수 있습니다.';
$lang['form_validation_alpha_numeric']		= '{field} 필드는 영숫자 문자 만 포함 할 수 있습니다.';
$lang['form_validation_alpha_numeric_spaces']	= '{field} 필드는 영숫자 문자와 공백 만 포함 할 수 있습니다.';
$lang['form_validation_alpha_dash']		= '{field} 필드에는 영숫자, 밑줄 및 대시 만 포함될 수 있습니다.';
$lang['form_validation_numeric']		= '{field} 필드는 숫자 만 포함해야합니다.';
$lang['form_validation_is_numeric']		= '{field} 필드는 숫자 만 포함해야합니다.';
$lang['form_validation_integer']		= '{field} 필드는 정수를 포함해야합니다.';
$lang['form_validation_regex_match']		= '{field} 필드가 올바른 형식이 아닙니다.';
$lang['form_validation_matches']		= '{field} 필드가 {param} 필드와 일치하지 않습니다.';
$lang['form_validation_differs']		= '{field} 필드는 {param} 필드와 달라야합니다.';
$lang['form_validation_is_unique'] 		= '{field} 필드는 고유 한 값을 포함해야합니다.';
$lang['form_validation_is_natural']		= '{field} 필드는 숫자 만 포함해야합니다.';
$lang['form_validation_is_natural_no_zero']	= '{field} 필드는 숫자 만 포함해야하며 0보다 커야합니다.';
$lang['form_validation_decimal']		= '{field} 필드는 10 진수를 포함해야합니다.';
$lang['form_validation_less_than']		= '{field} 필드는 {param}보다 작은 숫자를 포함해야합니다.';
$lang['form_validation_less_than_equal_to']	= '{field} 필드에는 {param} 이하의 숫자가 포함되어야합니다.';
$lang['form_validation_greater_than']		= '{field} 필드는 {param}보다 큰 숫자를 포함해야합니다.';
$lang['form_validation_greater_than_equal_to']	= '{field} 필드는 {param}보다 크거나 같은 숫자를 포함해야합니다.';
$lang['form_validation_error_message_not_set']	= '필드 이름 {field}에 해당하는 오류 메시지에 액세스 할 수 없습니다.';
$lang['form_validation_in_list']		= '{field} 필드는 {param} 중 하나 여야합니다.';
