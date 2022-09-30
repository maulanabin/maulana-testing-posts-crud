describe('View Post Page', () => {
    it('passes', () => {
      cy.visit('http://127.0.0.1:8070/post')
      cy.get(':nth-child(1) > .text-center > form > #view-post').click()
      cy.get('#back').click()
    })
  })
