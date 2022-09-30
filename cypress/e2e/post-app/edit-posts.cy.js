describe('Edit Post Page', () => {
    it('passes', () => {
      cy.visit('http://127.0.0.1:8070/post')
      cy.get('body')
      cy.get('#edit-post-8').click()
      cy.get('#status').select("Draft")
      cy.get('#update').click()
    })
  })
