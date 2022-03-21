const {checkName, checkEmail, checkPwd} = require('../components/scripts/functions.js')

const assert = require('assert')

// VERIFICATION NOM / PRENOM
describe(`Test de la valeur de l'input nom ou prénom`, function(){
    it(`devrait tester si la valeur est contient des lettres`, function(){
        assert.equal(checkName('Paul'), true)
        assert.equal(checkName('Jeau-Paul'), true)
        assert.equal(checkName('François'), true)
        assert.equal(checkName('Ra\'s al Ghul'), true)
    })
    it(`devrait tester si la valeur est ne contient pas de chiffre`, function(){
        assert.equal(checkName('Paul6'), false)
        assert.equal(checkName('123'), false)
        assert.equal(checkName(23), false)
    })
    it(`devrait tester si la valeur est ne contient pas de caractère non autorisé`, function(){
        assert.equal(checkName('Paul@'), false)
        assert.equal(checkName('$paule'), false)
        assert.equal(checkName('*paule'), false)
        assert.equal(checkName('#s'), false)
        assert.equal(checkName('puç'), true)
    })
    it(`devrait tester si la valeur est ne contient pas de booléen`, function(){
        assert.equal(checkName(true), false)
    })
})

// VERIFICATION EMAIL
describe(`Test de la valeur de l'input email`, function(){
    it(`devrait tester si la valeur est au bon format`, function(){
        assert.equal(checkEmail('Paul'), false)
        assert.equal(checkEmail('Paul6@test'), false)
        assert.equal(checkEmail('123@test.de'), true)
    })
    it(`devrait tester si la valeur n'est pas un booléen`, function(){
        assert.equal(checkEmail(true), false)
    })
})


// VERIFICATION PASSWORD
describe(`Test de la valeur de l'input password`, function(){
    it(`devrait tester si la valeur contient au moins 8 caractères`, function(){
        assert.equal(checkPwd('Paul.1'), false) // <8
        assert.equal(checkPwd('Paul6@test'), true) // >8
        assert.equal(checkPwd('Paul6@te'), true) //=8
    })
    it(`devrait tester si la valeur contient au max 15 caractères`, function(){
        assert.equal(checkPwd('Paul*15eEa56eT89'), false) // >15
        assert.equal(checkPwd('Paul6@test'), true) // < 15
        assert.equal(checkPwd('Paul6@test568dT'), true) // = 15

    })
    it(`devrait tester si la valeur contient un caractère spécial`, function(){
        assert.equal(checkPwd('Paule56d'), false)
        assert.equal(checkPwd('123@Testde'), true)
    })
    it(`devrait tester si la valeur contient un chiffre`, function(){
        assert.equal(checkPwd('paulEE-*'), false)
        assert.equal(checkPwd('123@Testde'), true)
    })
    it(`devrait tester si la valeur contient une majuscule`, function(){
        assert.equal(checkPwd('paule56*'), false)
        assert.equal(checkPwd('123@Testde'), true)
    })
    it(`devrait tester si la valeur contient une minuscule`, function(){
        assert.equal(checkPwd('PAULE56*'), false)
        assert.equal(checkPwd('123@Testde'), true)
    })
    it(`devrait tester si la valeur n'est pas un booléen`, function(){
        assert.equal(checkPwd(true), false)
    })
})