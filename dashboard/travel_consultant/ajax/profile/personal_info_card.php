<?php

    header('Content-Type: application/json');

    include_once(__DIR__ . '/../../../dashboard_user_details.php');

    try {

        $userId = $_GET['user_id'] ?? '';

        if (empty($userId)) {
            echo json_encode([
                'status'  => false,
                'message' => 'User ID is required'
            ]);
            exit;
        }

        $nationalities = [
            'Afghanistan' => 'Afghan',
            'Albania' => 'Albanian',
            'Algeria' => 'Algerian',
            'Andorra' => 'Andorran',
            'Angola' => 'Angolan',
            'Antigua and Barbuda' => 'Antiguan',
            'Argentina' => 'Argentine',
            'Armenia' => 'Armenian',
            'Australia' => 'Australian',
            'Austria' => 'Austrian',
            'Azerbaijan' => 'Azerbaijani',
            'Bahamas' => 'Bahamian',
            'Bahrain' => 'Bahraini',
            'Bangladesh' => 'Bangladeshi',
            'Barbados' => 'Barbadian',
            'Belarus' => 'Belarusian',
            'Belgium' => 'Belgian',
            'Belize' => 'Belizean',
            'Benin' => 'Beninese',
            'Bhutan' => 'Bhutanese',
            'Bolivia' => 'Bolivian',
            'Bosnia and Herzegovina' => 'Bosnian',
            'Botswana' => 'Motswana',
            'Brazil' => 'Brazilian',
            'Brunei' => 'Bruneian',
            'Bulgaria' => 'Bulgarian',
            'Burkina Faso' => 'Burkinabe',
            'Burundi' => 'Burundian',
            'Cambodia' => 'Cambodian',
            'Cameroon' => 'Cameroonian',
            'Canada' => 'Canadian',
            'Cape Verde' => 'Cape Verdean',
            'Central African Republic' => 'Central African',
            'Chad' => 'Chadian',
            'Chile' => 'Chilean',
            'China' => 'Chinese',
            'Colombia' => 'Colombian',
            'Comoros' => 'Comorian',
            'Congo' => 'Congolese',
            'Costa Rica' => 'Costa Rican',
            'Croatia' => 'Croatian',
            'Cuba' => 'Cuban',
            'Cyprus' => 'Cypriot',
            'Czech Republic' => 'Czech',
            'Denmark' => 'Danish',
            'Djibouti' => 'Djiboutian',
            'Dominica' => 'Dominican',
            'Dominican Republic' => 'Dominican',
            'Ecuador' => 'Ecuadorian',
            'Egypt' => 'Egyptian',
            'El Salvador' => 'Salvadoran',
            'Estonia' => 'Estonian',
            'Eswatini' => 'Swazi',
            'Ethiopia' => 'Ethiopian',
            'Fiji' => 'Fijian',
            'Finland' => 'Finnish',
            'France' => 'French',
            'Gabon' => 'Gabonese',
            'Gambia' => 'Gambian',
            'Georgia' => 'Georgian',
            'Germany' => 'German',
            'Ghana' => 'Ghanaian',
            'Greece' => 'Greek',
            'Grenada' => 'Grenadian',
            'Guatemala' => 'Guatemalan',
            'Guinea' => 'Guinean',
            'Guyana' => 'Guyanese',
            'Haiti' => 'Haitian',
            'Honduras' => 'Honduran',
            'Hungary' => 'Hungarian',
            'Iceland' => 'Icelander',
            'India' => 'Indian',
            'Indonesia' => 'Indonesian',
            'Iran' => 'Iranian',
            'Iraq' => 'Iraqi',
            'Ireland' => 'Irish',
            'Israel' => 'Israeli',
            'Italy' => 'Italian',
            'Jamaica' => 'Jamaican',
            'Japan' => 'Japanese',
            'Jordan' => 'Jordanian',
            'Kazakhstan' => 'Kazakhstani',
            'Kenya' => 'Kenyan',
            'Kuwait' => 'Kuwaiti',
            'Nepal' => 'Nepali',
            'Netherlands' => 'Dutch',
            'New Zealand' => 'New Zealander',
            'Nigeria' => 'Nigerian',
            'Norway' => 'Norwegian',
            'Pakistan' => 'Pakistani',
            'Philippines' => 'Filipino',
            'Poland' => 'Polish',
            'Portugal' => 'Portuguese',
            'Qatar' => 'Qatari',
            'Romania' => 'Romanian',
            'Russia' => 'Russian',
            'Saudi Arabia' => 'Saudi',
            'Singapore' => 'Singaporean',
            'South Africa' => 'South African',
            'South Korea' => 'South Korean',
            'Spain' => 'Spanish',
            'Sri Lanka' => 'Sri Lankan',
            'Sweden' => 'Swedish',
            'Switzerland' => 'Swiss',
            'Thailand' => 'Thai',
            'Turkey' => 'Turkish',
            'United Arab Emirates' => 'Emirati',
            'United Kingdom' => 'British',
            'United States' => 'American',
            'Vietnam' => 'Vietnamese',
            'Zimbabwe' => 'Zimbabwean'
        ];

        $sqlUserDetails = $conn->prepare("
            SELECT
                ste.firstname AS per_info_fname,
                ste.lastname AS per_info_lname,
                ste.email AS per_info_email,
                ste.country_code AS per_info_phone_prefix,
                ste.contact_no AS per_info_phone,
                ste.date_of_birth AS per_info_dob,
                ste.nominee_name AS per_info_nominee_name,
                ste.nominee_relation AS per_info_nominee_relation,
                cun.country_name,
                CONCAT(
                    UPPER(LEFT(ste.gender, 1)),
                    LOWER(SUBSTRING(ste.gender, 2))
                ) AS per_info_gender
            FROM ca_travelagency ste
            LEFT JOIN countries cun
                ON cun.id = ste.country
            WHERE ste.ca_travelagency_id = :user_id
            LIMIT 1
        ");

        $sqlUserDetails->execute([
            ':user_id' => $userId
        ]);

        $userDetails = $sqlUserDetails->fetch(PDO::FETCH_ASSOC);

        if ($userDetails) {

            $countryName = ucwords(strtolower(trim($userDetails['country_name'] ?? '')));

            $userDetails['per_info_nationality'] =
                $nationalities[$countryName] ?? '';

            unset($userDetails['country_name']);

            echo json_encode([
                'status' => true,
                'data'   => $userDetails
            ]);

        } else {

            echo json_encode([
                'status'  => false,
                'message' => 'User not found'
            ]);
        }

    } catch (PDOException $e) {

        echo json_encode([
            'status'  => false,
            'message' => $e->getMessage()
        ]);
    }
?>