describe('Delete Post', () => {
    it('passes', () => {
      cy.visit('http://127.0.0.1:8070/post')
      cy.get('#delete-post-6').click()
    })
  })
