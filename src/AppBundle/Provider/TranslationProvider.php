<?php

namespace AppBundle\Provider;

class TranslationProvider extends BaseProvider
{
    /**
     * @param array $domainIds
     * @param array $fileLocationIds
     * @param array $localeIds
     *
     * @return \stdClass
     */
    public function getTranslations(array $domainIds, array $fileLocationIds, array $localeIds)
    {
        return $this->client->get('translations', [
            'query' => [
                'domain_ids' => $domainIds,
                'location_ids' => $fileLocationIds,
                'locale_ids' => $localeIds
            ]
        ]);
    }

    /**
     * @param array $translations
     *
     * @return string
     */
    public function upTranslations(array $translations)
    {
        return $this->client->post('translations/import', [
            'form_params' => $translations
        ]);
    }
}
