<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Currency converter</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.14/vue.common.dev.min.js" integrity="sha512-TpgbLHXaTCAZ7ULhjopb1PveTz5Jx6KEQUtMfXhV0m0EArh+6O8ybZjjDN1Yug6oagN6iFm6EoMjuYSiFr0qXQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <h1 class="text-5xl w-auto text-gray-700" style="color:#ef3b2d">Currency converter</h1>
                </div>

                <div class="mt-8 bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6 text-white">
                        <form action="/convert" method="POST" id="form" @submit.prevent="submit">
                            @csrf
                            <div class="flex flex-col mb-4">
                                <label for="from" class="font-bold mb-2">From</label>
                                <select name="from" id="from" class="text-gray-800 p-2 rounded" required v-model="form.from">
                                    <option value="" disabled selected>Choose a from currency</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="HUF">HUF</option>
                                    <option value="GBP">GBP</option>
                                </select>
                                <div v-if="errors.from.length" class="text-red-500 mt-2">
                                    <span v-for="(error, index) in errors.from" :key="index" v-text="error"></span>
                                </div>
                            </div>
                            <div class="flex flex-col mb-4">
                                <label for="to" class="font-bold mb-2">To</label>
                                <select name="to" id="to" class="text-gray-800 p-2 rounded" required v-model="form.to">
                                    <option value="" disabled selected>Choose a to currency</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="HUF">HUF</option>
                                    <option value="GBP">GBP</option>
                                </select>
                                <div v-if="errors.to.length" class="text-red-500 mt-2">
                                    <span v-for="(error, index) in errors.to" :key="index" v-text="error"></span>
                                </div>
                            </div>
                            <div class="flex flex-col mb-4">
                                <label for="value" class="font-bold mb-2">Value</label>
                                <input type="number" name="fromValue" class="text-gray-800 p-2 rounded" value="1" required v-model.number="form.fromValue">
                                <div v-if="errors.fromValue.length" class="text-red-500 mt-2">
                                    <span v-for="(error, index) in errors.fromValue" :key="index" v-text="error"></span>
                                </div>
                            </div>
                            <div class="flex justify-center mb-4" v-if="convertedValue">
                                <h5 class="text-3xl" v-text="convertedValue"></h5>
                            </div>
                            <div class="flex justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="submit">Convert</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            new Vue({
                el: '#form',
                data: {
                    form: {
                        from: '',
                        to: '',
                        fromValue: 1,
                        fix: false
                    },
                    convertedValue: null,
                    errors: {
                        from: [],
                        to: [],
                        fromValue: [],
                    }
                },
                methods: {
                    async submit() {
                        try {
                            let { data } = await axios.post('/convert', this.form)

                            this.convertedValue = data.result
                        } catch (error) {
                            let errors = error.response.data.errors

                            Object.keys(errors).forEach(field => {
                                this.errors[field] = errors[field]
                            })
                        }
                    }
                }
            })
        </script>
    </body>
</html>
