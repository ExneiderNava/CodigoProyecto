
package View;


public class InicioDeSeccion extends javax.swing.JFrame {

   
    public InicioDeSeccion() {
        initComponents();
        fondo();
    }
    
    public void fondo(){
        javax.swing.ImageIcon fondo = new javax.swing.ImageIcon(getClass().getResource("/View/imagenes/Fondo_general.jpg"));
        javax.swing.JLabel fondoLabel = new javax.swing.JLabel(fondo);
        fondoLabel.setSize(Fondo.getWidth(), Fondo.getHeight());
        Fondo.setLayout(null);
        Fondo.add(fondoLabel);
        Fondo.setComponentZOrder(fondoLabel, Fondo.getComponentCount() - 1);
    }

    
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        Fondo = new javax.swing.JPanel();
        Tx_codigoUsuario = new javax.swing.JLabel();
        bt_ingresar = new javax.swing.JButton();
        logo = new javax.swing.JLabel();
        ps_codigo = new javax.swing.JPasswordField();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        Fondo.setBackground(null);

        Tx_codigoUsuario.setFont(new java.awt.Font("Segoe UI", 3, 36)); // NOI18N
        Tx_codigoUsuario.setForeground(new java.awt.Color(255, 255, 255));
        Tx_codigoUsuario.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        Tx_codigoUsuario.setText("Código de usuario");
        Tx_codigoUsuario.setToolTipText("");

        bt_ingresar.setText("Ingresar");
        bt_ingresar.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                bt_ingresarMouseClicked(evt);
            }
        });

        logo.setIcon(new javax.swing.ImageIcon("C:\\Users\\Usuario\\Desktop\\Proyecto Ebenezer\\LOGO-EBENEZER-final-20141.png")); // NOI18N

        ps_codigo.setFont(new java.awt.Font("Segoe UI", 0, 24)); // NOI18N
        ps_codigo.setHorizontalAlignment(javax.swing.JTextField.CENTER);

        javax.swing.GroupLayout FondoLayout = new javax.swing.GroupLayout(Fondo);
        Fondo.setLayout(FondoLayout);
        FondoLayout.setHorizontalGroup(
            FondoLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(FondoLayout.createSequentialGroup()
                .addContainerGap(319, Short.MAX_VALUE)
                .addGroup(FondoLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.CENTER)
                    .addComponent(Tx_codigoUsuario, javax.swing.GroupLayout.PREFERRED_SIZE, 459, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(bt_ingresar, javax.swing.GroupLayout.PREFERRED_SIZE, 195, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(logo, javax.swing.GroupLayout.PREFERRED_SIZE, 299, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(ps_codigo, javax.swing.GroupLayout.PREFERRED_SIZE, 392, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addGap(268, 268, 268))
        );
        FondoLayout.setVerticalGroup(
            FondoLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(FondoLayout.createSequentialGroup()
                .addGap(30, 30, 30)
                .addComponent(logo, javax.swing.GroupLayout.PREFERRED_SIZE, 145, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addComponent(Tx_codigoUsuario, javax.swing.GroupLayout.PREFERRED_SIZE, 74, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(18, 18, 18)
                .addComponent(ps_codigo, javax.swing.GroupLayout.PREFERRED_SIZE, 53, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(54, 54, 54)
                .addComponent(bt_ingresar, javax.swing.GroupLayout.PREFERRED_SIZE, 42, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(184, Short.MAX_VALUE))
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(Fondo, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(Fondo, javax.swing.GroupLayout.Alignment.TRAILING, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void bt_ingresarMouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_bt_ingresarMouseClicked
        
        String codigo = new String(ps_codigo.getPassword());
        
        if (codigo.equals("Xre65g")){
            try {
                java.awt.Desktop.getDesktop().browse(new java.net.URI("https://forms.office.com/Pages/DesignPageV2.aspx?origin=shell"));
            } catch (Exception e){
                e.printStackTrace();
            }
        }
            
    }//GEN-LAST:event_bt_ingresarMouseClicked

    

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JPanel Fondo;
    private javax.swing.JLabel Tx_codigoUsuario;
    private javax.swing.JButton bt_ingresar;
    private javax.swing.JLabel logo;
    private javax.swing.JPasswordField ps_codigo;
    // End of variables declaration//GEN-END:variables
}
