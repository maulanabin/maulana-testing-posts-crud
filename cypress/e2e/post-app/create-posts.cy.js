import { Input } from "postcss"

describe('Create Post Page', () => {
  it('passes', () => {
    cy.visit('http://127.0.0.1:8070/post')
    cy.get('#create-new-post').click()
    cy.get('#title').type(" Peningkatan Utilisasi Jaringan Distributed Storage System Menggunakan Kombinasi Server dan Link Load Balancing")
    cy.get('#status').select("Publish")
    cy.get('#content-posts').type("Distributed Storage System (DSS) memiliki sejumlah perangkat server penyimpanan yang terhubung dengan banyak perangkat switch untuk meningkatkan utilisasi jaringan.")
    cy.get('#save').click()
  })
})
