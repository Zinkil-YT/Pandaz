# **Pandaz**
**The Official Core System For MCPE Practice Server Pandaz.** 🎮🔥

<hr>

## Features:
- [x] FFA arena management
- [x] Bots Duels system
- [x] Duels system
  - Ranked and Unranked
  - Duration management
  - Spectators
- [x] Party system
  - Maximum membeers is based on rank (lowest = 8, highest = 20)
  - Manage privacy (require an invitation to join or public)
  - Manage members
  - Party duels
  - Party chat (use `*` before your message)
- [x] Various statistical trackings (of use and deprecated)
  - Kills
  - Deaths
  - KDR
  - Killstreak (current and best)
  - Elo
  - Levels
  - Daily Kills
  - Daily Deaths
- [x] Scoreboards
- [x] Leaderboards
- [x] Discord webhook system (messages, embeds)
  - Player join and quit (Public)
  - Anti-Cheat alerts (Staff)
  - Players reports (Staff)
  - Staff notification (Staff)
- [x] Custom entity creation
  - Fully custom throwable potions (2 variations)
  - Fully custom ender pearls
  - Fully custom rods
- [x] Cosmetics & Player-Based Preferences
  - Auto Rekit
  - Auto Queue
  - Auto (Toggle) Sprint
- [x] PvP stats counters
  - CPS Counter
  - Combo Counter
  - Pots Counter
  - Reach Counter
- [x] Ranks & Permissions
- [x] Staff utilities
  - Staff mode (Staff portal, Teleporter)
  - Permanent ban
  - Temporary ban
  - kick
  - Mute
  - Freeze
  - Player info to get all information about a player
  - Alias to know if a player is alting
  - All bans are carried out through both an IP and client-id blacklisting
  - Notifications on rank changes, ban/mute/rank expirations, gamemode changes, anti-cheat alerts
  - Staff chat (use `!` before your message)
- [x] Anti-Cheat
  - Reach
  - CPS
  - High ping
- [x] Anti-Abuse
  - Swearing
  - Advertising
  - Toxic
- [x] Capes system
  - Capes on join (Based on rankes)
  - Capes can be choosed by the player
- [x] Anti-Toolbox
  - If hackers tried joining the server with toolbox they will stuck on infinite locating server and if they joined they will get kicked
- [x] Good respawn system
  - when a player get killed he dont get death menu (Respawn, Main menu) it send him to lobby without getting death menu and give the killer his kills and rewards
- [x] Levels system

## Config
- [x] Arena Config
```yaml
---

duel-arenas: 
    example-arena:
    
        # The coords where players spawn in a party duel.
        center:
          x: 1
          "y": 1
          z: 1
          
        # The name of the world.
        level: duelworld
        
        # Whether you want to enable player building or not.
        build: true
        
        # The coords where the player spawns in a duel.
        player-pos:
          x: 1
          "y": 1
          z: 1
          
        # The coords where the opponent spawns in a duel.
        opponent-pos:
          x: 1
          "y": 1
          z: 1
          
        # Configure what gamemode this duel map is for.
        # Gamemodes: nodebuff, gapple, fist, sumo, combo
        modes:
          - nodebuff
...
```

- [x] Leaderboard Config (staticfloatingtexts, updatingfloatingtexts)
```yaml
---

# You can name this whatever you want.
topkills:

    x: 1 #x coord where the floatingtext spawns in.
    y: 1 #y coord where the floatingtext spawns in.
    z: 1 #z coord where the floatingtext spawns in.
    
    # The Title of the floating text.
    title: "Top Kills"
    
    # The bottom part of the floating text.
    
    # Allowed variables: {world}, {ip}, {discord}, {shop}, {vote}, {doubleline}, {line}, {player}, {kills}, {deaths}, {kdr}, {elo}, {coins}, {streak}, {player_health}, {player_max_health}, {online_players}, {online_max_players}, {topkills}, {topdeaths}, {topkdr}, {topelo}, {toplevels}, {topwins}, {toplosses}, {topkillstreaks}, {topdailykills} and {topdailydeaths}
    
    text: "{doubleline}{topkills}"
    
    # The world where the floating text spawns in.
    level: leaderboardworld
    
...
```

## Todo list:
- [ ] Events system (Tournament)
- [ ] Leagues (Bronze, Silver, etc..)
- [ ] Custom bot duels
- [ ] MlgRush duels
- [ ] Tags system
- [ ] Anti 2v1/Clean/Intrrupt/Teaming
- [ ] Market/Shop system 
- [ ] Bots emote on win
- [ ] Voting system
- [ ] Anti-Cheat improvments to support more types of cheats
- [ ] Add multi languages system
- [ ] Replay system
- [ ] KitPvP gamemode
- [ ] Anti-VPN/Proxy
- [ ] Custom bossbars
- [ ] Better spectating
- [ ] Duels invites
- [ ] Anti-Swearing/Toxic improvments to support more languages
- [ ] Better color scheme

## Questions or any help:

<hr>

Contact me on discord **Zinkil#2006** you can also join our discord server [Pandaz Practice](https://discord.gg/2zt7P5EUuN)

Feel free to subscribe to my channel [MR Zinkil](https://www.youtube.com/channel/UCW1PI028SEe2wi65w3FYCzg) 😇👍

<hr>

### <b>Made with ❤ by Zinkil</b>