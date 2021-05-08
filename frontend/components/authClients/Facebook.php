<?php

namespace frontend\components\authClients;

class Facebook extends \yii\authclient\clients\Facebook
{
    /**
     * {@inheritdoc}
     */
    public $attributeNames = [
        'name',
        'email',
        'birthday',
        'gender',
        'location',
        'picture'
    ];

    public function getFormattedProfileInfo()
    {
        $profileInfo = $this->initUserAttributes();

        $data = [
            'name'     => $profileInfo['name'] ?? null,
            'email'    => $profileInfo['email'] ?? null,
            'birthday' => $profileInfo['birthday'] ?? null,
            'gender'   => $profileInfo['gender'] ?? null,
            'location' => isset($profileInfo['location']) ? $profileInfo['location']['name'] : null,
            'picture'  => isset($profileInfo['picture']) ? $profileInfo['picture']['data']['url'] : null,
        ];

        return array_filter($data);
    }
}