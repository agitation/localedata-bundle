ag.api.Endpoint.register({
    "localedata.v1/Country.get": [
        "common.v1/String",
        "localedata.v1/Country"
    ],
    "localedata.v1/Country.search": [
        "localedata.v1/CountrySearch",
        "localedata.v1/Country[]"
    ],
    "localedata.v1/Timezone.get": [
        "common.v1/String",
        "localedata.v1/Timezone"
    ],
    "localedata.v1/Timezone.search": [
        "localedata.v1/TimezoneSearch",
        "localedata.v1/Timezone[]"
    ],
    "localedata.v1/Currency.get": [
        "common.v1/String",
        "localedata.v1/Currency"
    ],
    "localedata.v1/Currency.search": [
        "localedata.v1/CurrencySearch",
        "localedata.v1/Currency[]"
    ]
});
ag.api.Object.register({
    "localedata.v1/Country": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "localedata.v1/Timezone": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "localedata.v1/CurrencySearch": {
        "props": []
    },
    "localedata.v1/CountrySearch": {
        "props": []
    },
    "localedata.v1/TimezoneSearch": {
        "props": []
    },
    "localedata.v1/Currency": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    }
});